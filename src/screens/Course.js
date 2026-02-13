import React, { useEffect, useState } from 'react';
import {
  View,
  Text,
  StyleSheet,
  StatusBar,
  TouchableOpacity,
  TextInput,
  ScrollView,
  ActivityIndicator
} from 'react-native';

import {
  widthPercentageToDP as wp,
  heightPercentageToDP as hp,
} from 'react-native-responsive-screen';

import { RFPercentage } from 'react-native-responsive-fontsize';
import IonIcon from 'react-native-vector-icons/Ionicons';
import Icon from 'react-native-vector-icons/FontAwesome5';
import { useNavigation } from '@react-navigation/native';
import { SafeAreaView } from 'react-native-safe-area-context';
import { getApi } from '../config/api';

const Course = () => {
  const navigation = useNavigation();
  const [courses, setCourses] = useState([]);
  const [search, setSearch] = useState('');
  const [loading, setLoading] = useState(false);
  const [testimonials, setTestimonials] = useState([]);

  // 🔹 Fetch categories
  const getCategory = async () => {
    try {
      setLoading(true);
      const res = await getApi('/get-category');
      console.log('Courses Data:', JSON.stringify(res));

      // Try multiple paths to find the data array
      const data = res?.categories?.data || res?.data || res?.categories || [];

      setCourses(data);
    } catch (error) {
      console.log('Error fetching courses:', error);
    } finally {
      setLoading(false); // 🔥 stop loader
    }
  };

  // 🔹 Fetch testimonials
  const getTestimonials = async () => {
    try {
      const data = await getApi('/get-testimonials');
      console.log('Testimonials:', data);

      // Try multiple potential data paths from API
      // Backend usually returns { data: [...] } or just [...]
      let apiData = data?.data || data?.testimonials || (Array.isArray(data) ? data : []) || [];

      if (!Array.isArray(apiData)) {
        apiData = [];
      }

      setTestimonials(apiData.filter(item => item !== null && item !== undefined));
    } catch (error) {
      console.log('Error fetching testimonials:', error);
    }
  };

  useEffect(() => {
    getCategory();
    getTestimonials();
  }, []);

  // 🔹 Convert "fa fa-book" → "book"
  const getIconName = (icon) => {
    if (!icon) return 'question-circle';
    const parts = icon.split(' ');
    return parts[1]?.replace('fa-', '') || 'question-circle';
  };

  // 🔹 Search filter
  const filteredCourses = courses.filter(item =>
    item?.name?.toLowerCase().includes(search.toLowerCase())
  );

  return (
    <SafeAreaView style={styles.container}>
      <StatusBar backgroundColor="#fff" barStyle="dark-content" />

      {/* ---------- Header ---------- */}
      <View style={styles.header}>
        <TouchableOpacity
          style={styles.backBtn}
          onPress={() => navigation.goBack()}
        >
          <IonIcon name="arrow-back" size={24} color="#fff" />
        </TouchableOpacity>

        <Text style={styles.headerTitle}>Courses</Text>
        <View />
      </View>

      {/* ---------- Search Bar ---------- */}
      <View style={styles.searchContainer}>
        <IonIcon name="search-outline" size={22} color="#2D6EFF" />
        <TextInput
          placeholder="Search Courses"
          placeholderTextColor="#555"
          style={styles.input}
          value={search}
          onChangeText={setSearch}
        />
      </View>

      {/* ---------- Courses Grid ---------- */}
      {/* ---------- Courses Grid ---------- */}
      <ScrollView showsVerticalScrollIndicator={false}>
        {loading ? (
          <View style={styles.loaderContainer}>
            <ActivityIndicator size="large" color="#000" />
            <Text style={styles.loadingText}>Loading courses...</Text>
          </View>
        ) : (
          <>
            <View style={styles.courseListView}>
              {filteredCourses.map(item => {
                const iconName = getIconName(item.icon);

                return (
                  <TouchableOpacity
                    key={item.id}
                    style={[
                      styles.courseCard,
                      { backgroundColor: item.color || '#EEF2FF' },
                    ]}
                    onPress={() =>
                      navigation.navigate('CourseDetails', {
                        categoryId: item.id,
                        slug: item.slug,
                        name: item.name,
                      })
                    }
                  >
                    <Icon name={iconName} size={26} color="#fff" />
                    <Text style={[styles.courseTitle, { color: '#fff' }]}>
                      {item.name}</Text>
                  </TouchableOpacity>
                );
              })}
            </View>

            {filteredCourses.length === 0 && (
              <Text style={styles.emptyText}>No courses found</Text>
            )}

            {/* Testimonials Section */}
            {testimonials.length > 0 && (
              <View style={styles.testimonialsSection}>
                <Text style={styles.sectionTitle}>What Our Students Say</Text>
                <ScrollView
                  horizontal
                  showsHorizontalScrollIndicator={false}
                  contentContainerStyle={styles.testimonialsContainer}
                >
                  {testimonials.map((item, index) => (
                    <View key={index} style={styles.testimonialCard}>
                      <Text style={styles.testimonialText} numberOfLines={4}>
                        "{item.message || item.testimonial || item.text}"
                      </Text>
                      <View style={styles.testimonialFooter}>
                        <Text style={styles.testimonialName}>
                          {item.name || item.user_name || 'Anonymous'}
                        </Text>
                        {item.designation && (
                          <Text style={styles.testimonialDesignation}>
                            {item.designation}
                          </Text>
                        )}
                      </View>
                    </View>
                  ))}
                </ScrollView>
              </View>
            )}
          </>
        )}
      </ScrollView>

    </SafeAreaView>
  );
};

export default Course;

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#fff',
  },

  header: {
    flexDirection: 'row',
    alignItems: 'center',
    padding: wp('5%'),
    gap: wp('5%'),
    justifyContent: "space-between"
  },

  backBtn: {
    width: wp('10%'),
    height: wp('10%'),
    borderRadius: wp('10%'),
    backgroundColor: '#2D6EFF',
    justifyContent: 'center',
    alignItems: 'center',
  },

  headerTitle: {
    fontSize: RFPercentage(2.5),
    fontWeight: '500',
    fontFamily: 'Poppins-SemiBold',
  },

  searchContainer: {
    flexDirection: 'row',
    alignItems: 'center',
    width: wp('90%'),
    height: hp('6%'),
    backgroundColor: '#EEF2FF',
    borderRadius: wp('3%'),
    alignSelf: 'center',
    paddingHorizontal: wp('3%'),
    // marginTop: hp('2%'),
  },

  input: {
    flex: 1,
    fontSize: RFPercentage(2),
    marginHorizontal: wp('1%'),
    fontFamily: 'Poppins-Regular',
  },

  courseListView: {
    flexDirection: 'row',
    flexWrap: 'wrap',
    justifyContent: 'space-between',
    paddingHorizontal: wp('5%'),
    paddingVertical: hp('2%'),
  },

  courseCard: {
    width: wp('25%'),
    height: hp('13%'),
    borderRadius: wp('3%'),
    justifyContent: 'center',
    alignItems: 'center',
    marginBottom: hp('2%'),
    elevation: 3,
  },

  testimonialsSection: {
    paddingVertical: hp('2%'),
    paddingLeft: wp('5%'),
    marginTop: hp('2%'),
  },

  sectionTitle: {
    fontSize: RFPercentage(2.5),
    fontWeight: '700',
    color: '#333',
    marginBottom: hp('2%'),
    fontFamily: 'Poppins-SemiBold',
  },

  testimonialsContainer: {
    paddingRight: wp('5%'),
    paddingBottom: hp('2%'),
  },

  testimonialCard: {
    width: wp('70%'),
    backgroundColor: '#EEF2FF',
    borderRadius: wp('4%'),
    padding: wp('4%'),
    marginRight: wp('4%'),
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 2 },
    shadowOpacity: 0.1,
    shadowRadius: 4,
    elevation: 3,
  },

  testimonialText: {
    fontSize: RFPercentage(1.8),
    color: '#555',
    fontStyle: 'italic',
    lineHeight: hp('3%'),
    fontFamily: 'Poppins-Regular',
    marginBottom: hp('1.5%'),
  },

  testimonialFooter: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    marginTop: hp('1%'),
  },

  testimonialName: {
    fontSize: RFPercentage(2),
    fontWeight: '600',
    color: '#2D6EFF',
    fontFamily: 'Poppins-SemiBold',
  },

  testimonialDesignation: {
    fontSize: RFPercentage(1.5),
    color: '#888',
    fontFamily: 'Poppins-Regular',
  },

  courseTitle: {
    marginTop: hp('1%'),
    fontSize: RFPercentage(1.6),
    fontWeight: '600',
    textAlign: 'center',
    fontFamily: 'Poppins-Regular',
  },

  emptyText: {
    textAlign: 'center',
    marginTop: hp('5%'),
    fontSize: RFPercentage(2),
    color: '#888',
  },
  loaderContainer: {
    marginTop: hp('20%'),
    alignItems: 'center',
  },

  loadingText: {
    marginTop: hp('2%'),
    fontSize: RFPercentage(2),
    color: '#000',
  },
});
