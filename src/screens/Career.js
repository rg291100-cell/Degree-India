import { useNavigation } from '@react-navigation/native';
import React, { useState, useEffect } from 'react';
import {
  View,
  Text,
  StyleSheet,
  Image,
  TouchableOpacity,
  ScrollView,
  Dimensions,
  StatusBar,
} from 'react-native';
import Icon from 'react-native-vector-icons/MaterialIcons';
import {
  widthPercentageToDP as wp,
  heightPercentageToDP as hp,
} from 'react-native-responsive-screen';
import { SafeAreaView } from 'react-native-safe-area-context';
import { getApi, BASE_IMAGE_URL } from '../config/api';

const { width } = Dimensions.get('window');

const Career = () => {
  const navigation = useNavigation();
  const [testimonials, setTestimonials] = useState([]);

  // Fetch testimonials
  const getTestimonials = async () => {
    try {
      const data = await getApi('/get-testimonials');
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
    getTestimonials();
  }, []);

  return (
    <SafeAreaView style={styles.safe}>
      <StatusBar barStyle="dark-content" backgroundColor="#fff" />
      <ScrollView style={styles.container} showsVerticalScrollIndicator={false}>
        {/* HEADER IMAGE + TITLE */}
        <View style={styles.headerBar}>
          <TouchableOpacity
            style={styles.backButton}
            onPress={() => navigation.goBack()}
          >
            <Icon name="arrow-back" size={26} color="#fff" />
          </TouchableOpacity>

          <Text style={styles.headerTitle}>Set My Goal</Text>
        </View>
        <View>
          <Image
            source={require('../assets/Image/Goal.png')}
            style={styles.headerImage}
          />

          {/* Header Top Bar */}
        </View>

        {/* Steps */}
        <Text style={styles.sectionTitle}>Steps Of Setting Your Goal</Text>

        <View style={styles.stepRow}>
          <Text style={styles.stepText}>Define Your Goal</Text>
          <Text style={styles.stepText}>| Explore Career Option</Text>
          <Text style={styles.stepText}>| Evaluate Yourself</Text>
        </View>

        {/* Counselor Section */}
        <Text style={styles.sectionTitle}>
          Talk To Career Counselor & Set Your Goal
        </Text>

        <View style={styles.actionContainer}>
          <TouchableOpacity
            onPress={() => navigation.navigate('BookYour')}
            style={styles.actionButton}
          >
            <Text style={styles.actionText}>Book Your Session</Text>
          </TouchableOpacity>

          <TouchableOpacity style={styles.actionButton}>
            <Text style={styles.actionText}>Call For Assistance</Text>
          </TouchableOpacity>
        </View>

        {/* Explore Options */}
        <Text style={styles.sectionTitle}>
          Talk To Career Counselor & Set Your Goal
        </Text>

        <View style={styles.iconGrid}>
          {[
            { name: 'search', label: 'Search' },
            { name: 'emoji-objects', label: 'By Skills' },
            { name: 'location-on', label: 'By State' },
            { name: 'business', label: 'By Sector' },
            { name: 'psychology', label: 'By Interest' },
            { name: 'work', label: 'By Profession' },
          ].map((item, index) => (
            <View key={index} style={styles.iconCard}>
              <Icon name={item.name} size={28} color="#000" />
              <Text style={styles.iconLabel}>{item.label}</Text>
            </View>
          ))}
        </View>

        {/* Testimonials */}
        {testimonials.length > 0 && (
          <>
            <Text style={styles.heading}>Testimonials</Text>

            <ScrollView
              horizontal
              showsHorizontalScrollIndicator={false}
              contentContainerStyle={styles.scrollContainer}
            >
              {testimonials.map((item, index) => (
                <View key={index} style={styles.card}>
                  <Image
                    source={
                      item.image_url
                        ? { uri: item.image_url.startsWith('http') ? item.image_url : `${BASE_IMAGE_URL}${item.image_url}` }
                        : require('../assets/Icons/Applogo.png')
                    }
                    style={styles.avatar}
                  />
                  <Text style={styles.title} numberOfLines={1}>{item.title || item.name || 'Anonymous'}</Text>
                  <Text style={styles.subtitle} numberOfLines={1}>{item.subtitle || item.designation || 'Student'}</Text>
                  <Text style={styles.desc} numberOfLines={4}>
                    {item.description || item.message || item.text || item.desc}
                  </Text>
                </View>
              ))}
            </ScrollView>
          </>
        )}
      </ScrollView>
    </SafeAreaView>
  );
};

export default Career;
const styles = StyleSheet.create({
  safe: {
    flex: 1,
    backgroundColor: '#fff',
  },

  container: {
    flex: 1,
    backgroundColor: '#fff',
  },

  headerImage: {
    width: '100%',
    height: 200,
    resizeMode: 'cover',
  },

  headerBar: {
    flexDirection: 'row',
    alignItems: 'center',
    padding: wp('5%'),
  },

  headerTitle: {
    fontSize: 20,
    color: '#000',
    marginLeft: 10,
    alignContent: 'center',
    left: width / 4,
    fontFamily: 'Poppins-SemiBold',
  },

  sectionTitle: {
    textAlign: 'center',
    fontSize: 16,
    fontWeight: '600',
    marginVertical: 8,
    color: '#000',
    fontFamily: 'Poppins-Regular',
  },

  stepRow: {
    flexDirection: 'row',
    backgroundColor: '#000',
    borderRadius: 10,
    justifyContent: 'center',
    alignSelf: 'center',
    paddingVertical: 12,
    paddingHorizontal: 10,
    width: '95%',
    flexWrap: 'wrap', // Allow wrapping if screen is small
  },

  stepText: {
    color: '#fff',
    paddingHorizontal: 8, // Increased padding
    fontSize: 12,
    marginTop: 2,
    fontFamily: 'Poppins-Regular',
  },

  actionContainer: {
    flexDirection: 'row',
    justifyContent: 'space-between', // Changed to space-between
    marginVertical: 10,
    marginHorizontal: 15, // Added margin horizontal
  },

  actionButton: {
    backgroundColor: '#000',
    borderRadius: 20,
    paddingVertical: 12,
    paddingHorizontal: 10,
    width: '48%', // Increased width
    alignItems: 'center',
    height: 55, // Increased height slightly
    justifyContent: 'center',
  },

  actionText: {
    color: '#fff',
    fontSize: 12, // Slightly smaller font to fit
    fontWeight: '600',
    fontFamily: 'Poppins-Regular',
    textAlign: 'center',
  },

  iconGrid: {
    flexDirection: 'row',
    flexWrap: 'wrap',
    justifyContent: 'space-between',
    marginHorizontal: 20,
    marginBottom: 40,
  },

  iconCard: {
    width: '30%',
    backgroundColor: '#f3f3f3',
    borderRadius: 15,
    paddingVertical: 14,
    alignItems: 'center',
    marginVertical: 8,
  },

  iconLabel: {
    marginTop: 5,
    fontSize: 12,
    color: '#333',
    textAlign: 'center',
    fontFamily: 'Poppins-Regular',

  },

  heading: {
    textAlign: 'center',
    fontSize: 18,
    // fontWeight: '00',
    color: '#000',
    marginVertical: 15,
    fontFamily: 'Poppins-SemiBold',

  },

  scrollContainer: {
    paddingHorizontal: 15,
    paddingBottom: 20,
  },

  card: {
    width: width * 0.7, // 70% of screen width
    backgroundColor: '#fff',
    borderRadius: 15,
    borderWidth: 1,
    borderColor: '#e0e0e0',
    padding: 15,
    alignItems: 'center',
    marginRight: 15,
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 2 },
    shadowOpacity: 0.1,
    shadowRadius: 4,
    elevation: 3,
  },

  avatar: {
    width: 70,
    height: 70,
    borderRadius: 35,
    marginBottom: 8,
  },

  title: {
    fontSize: 14,
    fontWeight: '500',
    color: '#000',
    fontFamily: 'Poppins-Black',

  },

  subtitle: {
    fontSize: 12,
    color: '#666',
    marginBottom: 6,
    fontFamily: 'Poppins-Regular',

  },

  desc: {
    fontSize: 10,
    color: '#333',
    textAlign: 'center',
    fontFamily: 'Poppins-Regular',

  },

  backButton: {
    width: wp('10%'),
    height: wp('10%'),
    borderRadius: wp('10%'),
    backgroundColor: '#2D6EFF',
    justifyContent: 'center',
    alignItems: 'center',
  },
});
