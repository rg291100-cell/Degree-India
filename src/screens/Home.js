
import {
  View,
  Text,
  ScrollView,
  StyleSheet,
  StatusBar,
  Image,
  TouchableOpacity,
  FlatList,
  Alert,
} from 'react-native';
import React, { useRef, useEffect, useState } from 'react';
import {
  widthPercentageToDP as wp,
  heightPercentageToDP as hp,
} from 'react-native-responsive-screen';
import { RFPercentage } from 'react-native-responsive-fontsize';
import { useNavigation } from '@react-navigation/native';
import { SafeAreaView } from 'react-native-safe-area-context';
import Icon from 'react-native-vector-icons/FontAwesome5';
import { getApi, BASE_IMAGE_URL } from '../config/api';
import axios from 'axios';
import AsyncStorage from '@react-native-async-storage/async-storage';

const Home = () => {
  const navigation = useNavigation();
  const [index, setIndex] = React.useState(0);
  const [banner, setBanner] = useState(null);
  const [whyJoinUs, setWhyJoinUs] = useState([]);
  const [testimonials, setTestimonials] = useState([]);
  const [myAdmission, setMyAdmission] = useState(null);

  const listRef = useRef(null);

  const Flag = [
    require('../assets/Image/india.png'),
    require('../assets/Image/Flag1.png'),
    require('../assets/Image/Flag2.png'),
    require('../assets/Image/Flag3.png'),
    require('../assets/Image/india.png'),
    require('../assets/Image/Flag1.png'),
    require('../assets/Image/Flag2.png'),
    require('../assets/Image/Flag3.png'),
    require('../assets/Image/india.png'),
    require('../assets/Image/Flag1.png'),
    require('../assets/Image/Flag2.png'),
    require('../assets/Image/Flag3.png'),
    require('../assets/Image/Flag2.png'),
    require('../assets/Image/Flag3.png'),
    require('../assets/Image/india.png'),
    require('../assets/Image/Flag1.png'),
    require('../assets/Image/Flag2.png'),
    require('../assets/Image/Flag3.png'),
  ];

  const getBannerApi = async () => {
    try {
      const data = await getApi('/get-banner', false);
      console.log('Banner Data:', data?.data?.[0]);
      const bannerItem = data?.data?.[0] || null;
      setBanner(bannerItem);
    } catch (err) {
      console.log('Banner error:', err.response?.data || err.message);
      setBanner(null);
    }
  };

  const getWhyJoinUs = async () => {
    try {
      const data = await getApi('/why-join-us');
      console.log('Why Join Us Data:', data);
      setWhyJoinUs(data.data || []);
    } catch (error) {
      console.log('Error fetching Why Join Us:', error);
    }
  };

  const getMyAdmissions = async () => {
    try {
      const data = await getApi('/admissions/my-admissions', true);
      console.log('My Admissions Response:', data);
      // ✅ FIX: Backend returns 'admissions' key, not 'data'
      const admission = data?.admissions?.[0] || null;
      setMyAdmission(admission);
    } catch (error) {
      console.log('API Error:', error);
    }
  };

  useEffect(() => {
    getMyAdmissions();
  }, []);

  const geTestimonials = async () => {
    try {
      const data = await getApi('/get-testimonials');
      console.log('testimonials data:', data);
      setTestimonials(data.data || []);
    } catch (error) {
      console.log('Error fetching Testimonials:', error);
    }
  };

  useEffect(() => {
    getBannerApi();
    getWhyJoinUs();
    geTestimonials();
  }, []);

  useEffect(() => {
    const interval = setInterval(() => {
      let nextIndex = index + 1;
      if (nextIndex >= Flag.length) {
        nextIndex = 0;
      }

      setIndex(nextIndex);

      if (listRef.current) {
        listRef.current.scrollToIndex({ index: nextIndex, animated: true });
      }
    }, 2000);

    return () => clearInterval(interval);
  }, [index]);

  const renderItem = ({ item }) => {
    const iconParts = item?.icon?.split(' ') || [];
    const iconName = iconParts[1]?.replace('fa-', '') || 'question-circle';

    return (
      <View style={styles.card}>
        <Icon name={iconName} size={24} color="#fff" />
        <Text
          style={[styles.title, { color: '#fff', fontSize: 13, marginTop: 5 }]}
        >
          {item.title || 'No title'}
        </Text>
      </View>
    );
  };

  return (
    <SafeAreaView style={styles.container}>
      <StatusBar barStyle="dark-content" backgroundColor="#fff" />
      <View style={styles.header}>
        <View />
        <View style={{ flexDirection: 'row', gap: 20 }}>
          <TouchableOpacity
            style={styles.button}
            onPress={() => navigation.navigate('Notification')}
          >
            <Image
              source={require('../assets/Icons/notification.png')}
              style={{ width: 40, height: 40 }}
            />
          </TouchableOpacity>
          <TouchableOpacity
            style={styles.button}
            onPress={() => navigation.navigate('Profile')}
          >
            <Image
              source={require('../assets/Icons/Applogo.png')}
              style={{ width: 40, height: 40 }}
            />
          </TouchableOpacity>
        </View>
      </View>

      <ScrollView contentContainerStyle={styles.scrollContent}>
        {/* Header Section */}
        <View style={styles.mainView}>
          <Image
            source={
              banner?.image_url
                ? {
                  uri: banner.image_url.startsWith('http')
                    ? banner.image_url
                    : `${BASE_IMAGE_URL}${banner.image_url}`,
                }
                : require('../assets/Image/Rectangle.png')
            }
            style={styles.image}
            resizeMode="cover"
          />

          <View style={styles.Textview}>
            <View>
              <Text style={styles.text}>{banner?.title || 'Welcome'}</Text>
              <Text style={styles.subText}>{banner?.description || ''}</Text>
            </View>
            <Image
              source={require('../assets/Image/logo.png')}
              style={styles.logo}
            />
          </View>

          <Text style={styles.sectionTitle}>Why Join Us</Text>
          <FlatList
            data={whyJoinUs}
            keyExtractor={item => item.id.toString()}
            renderItem={renderItem}
            horizontal={true}
            showsHorizontalScrollIndicator={false}
            contentContainerStyle={{
              paddingHorizontal: wp('3%'),
              paddingVertical: 10,
            }}
          />

          <View style={styles.topRow}>
            <TouchableOpacity
              onPress={() => navigation.navigate('Course')}
              style={styles.box}
            >
              <Image
                source={require('../assets/Image/maki.png')}
                style={styles.boxImg}
              />
              <Text style={styles.boxText}>Courses</Text>
            </TouchableOpacity>

            <TouchableOpacity
              onPress={() => navigation.navigate('Career')}
              style={styles.box}
            >
              <Image
                source={require('../assets/Image/bulb.png')}
                style={styles.boxImg}
              />
              <Text style={styles.boxText}>Career Counselling</Text>
            </TouchableOpacity>
          </View>
        </View>

        <TouchableOpacity onPress={() => navigation.navigate('Admission')}>
          <View style={styles.profileWrapper}>
            {/* Profile Image */}
            <View style={styles.profileImageContainer}>
              <Image
                source={require('../assets/Image/Profile.png')}
                style={styles.profileImage}
              />
            </View>

            {/* Card */}
            <View style={styles.cardContainer}>
              <Text style={styles.cardTitle}>My Admission Desk</Text>

              {myAdmission ? (
                <>
                  <View style={styles.cardRow}>
                    <View style={styles.col}>
                      <Text style={styles.label}>Enrolment No.</Text>
                      <Text style={styles.value} numberOfLines={1}>{myAdmission.enrollment_no}</Text>
                    </View>

                    <View style={styles.col}>
                      <Text style={styles.label}>College</Text>
                      <Text style={styles.value} numberOfLines={1}>
                        {myAdmission.university_name || myAdmission.college_name || 'N/A'}
                      </Text>
                    </View>
                  </View>

                  <View style={styles.cardRow}>
                    <View style={styles.col}>
                      <Text style={styles.label}>Fees Paid</Text>
                      <Text style={styles.value}>{myAdmission.paid_fees}</Text>
                    </View>

                    <View style={styles.col}>
                      <Text style={styles.label}>Course Type</Text>
                      <Text style={styles.value}>{myAdmission.course_type}</Text>
                    </View>
                  </View>
                  <View style={styles.cardRow}>
                    <View style={styles.col}>
                      <Text style={styles.label}>Course</Text>
                      <Text style={styles.value} numberOfLines={1}>
                        {myAdmission.course_name || 'N/A'}
                      </Text>
                    </View>
                  </View>
                </>
              ) : (
                <View style={{ paddingVertical: 20 }}>
                  <Text style={{ fontFamily: 'Poppins-Regular', color: '#666' }}>
                    No admission data found.
                  </Text>
                </View>
              )}
            </View>
          </View>
        </TouchableOpacity>

        <View style={styles.schoolcardWrapper}>
          <TouchableOpacity
            onPress={() => navigation.navigate('Educationalpartners')}
            style={styles.schoolcard}
          >
            <Image
              source={require('../assets/Image/image.png')}
              style={styles.boxImg}
            />
            <Text style={styles.boxText}>Academic Partners</Text>
          </TouchableOpacity>

          <TouchableOpacity
            onPress={() => navigation.navigate('ExpertTips')}
            style={styles.schoolcard2}
          >
            <Image
              source={require('../assets/Image/video.png')}
              style={styles.boxImg}
            />
            <Text style={styles.boxText}>Expert Tips</Text>
          </TouchableOpacity>
        </View>

        <View style={styles.schoolcardWrapper}>
          <TouchableOpacity
            onPress={() => navigation.navigate('Educational')}
            style={styles.schoolcard}
          >
            <Image
              source={require('../assets/Image/news.png')}
              style={styles.boxImg}
            />
            <Text style={styles.boxText}>Educational News</Text>
          </TouchableOpacity>

          <TouchableOpacity
            style={styles.schoolcard2}
            onPress={() => navigation.navigate('Career')}
          >
            <Image
              source={require('../assets/Image/job.png')}
              style={styles.boxImg}
            />
            <Text style={styles.boxText}>Job & Internships </Text>
          </TouchableOpacity>
        </View>

        <View style={styles.FlatListView}>
          <Text style={styles.Abrod}>Study Abroad</Text>

          <FlatList
            ref={listRef}
            data={Flag}
            horizontal
            showsHorizontalScrollIndicator={false}
            keyExtractor={(item, index) => index.toString()}
            renderItem={({ item }) => (
              <Image source={item} style={styles.flag} />
            )}
          />
        </View>

        <View style={styles.containerTes}>
          <Text style={styles.heading}>Testimonials</Text>
          {testimonials.length === 0 && (
            <Text style={{ fontFamily: 'Poppins-Regular', color: '#999' }}>No testimonials yet.</Text>
          )}
          <FlatList
            horizontal
            data={testimonials}
            showsHorizontalScrollIndicator={false}
            style={{ width: '100%' }}
            keyExtractor={item => item.id.toString()}
            contentContainerStyle={{ paddingHorizontal: 10 }}
            renderItem={({ item }) => (
              <View
                style={[
                  styles.card,
                  {
                    backgroundColor: '#f9f9f9',
                    padding: 15,
                    width: wp('70%'),
                    alignItems: 'flex-start',
                    borderRadius: 12,
                    borderWidth: 1,
                    borderColor: '#eee'
                  },
                ]}
              >
                <View style={{ flexDirection: 'row', alignItems: 'center' }}>
                  <Image
                    source={{
                      uri: item.image_url
                        ? (item.image_url.startsWith('http')
                          ? item.image_url
                          : `${BASE_IMAGE_URL}${item.image_url}`)
                        : 'https://via.placeholder.com/60'
                    }}
                    style={styles.avatar}
                  />
                  <View style={{ flex: 1, marginLeft: 10 }}>
                    <Text style={styles.title} numberOfLines={1}>
                      {item.title}
                    </Text>
                    <Text style={styles.subtitle}>{item.subtitle || 'Student'}</Text>
                  </View>
                </View>
                <Text style={[styles.desc, { marginTop: 10 }]} numberOfLines={3}>
                  {item.description}
                </Text>
              </View>
            )}
          />
        </View>
      </ScrollView>
    </SafeAreaView>
  );
};

export default Home;

const styles = StyleSheet.create({
  container: { flex: 1, backgroundColor: '#fff' },
  scrollContent: { paddingBottom: 30 },

  mainView: { marginTop: hp('2%'), alignItems: 'center' },

  image: {
    width: wp('95%'),
    height: hp('25%'),
    borderRadius: wp('2%'),
  },

  Textview: {
    marginTop: hp('-24%'),
    flexDirection: 'row',
    width: wp('85%'),
    right: wp('-2%'),
    alignItems: 'center',
    justifyContent: 'center',
  },

  text: {
    fontSize: RFPercentage(2.5),
    fontWeight: '600',
    textAlign: 'center',
    left: wp('5%'),
    color: '#fff',
    fontFamily: 'Poppins-Black',
  },
  subText: {
    fontSize: RFPercentage(1.5),
    marginTop: hp('0.1%'),
    left: wp('4%'),
    color: '#fff',
    textAlign: 'center',
    fontFamily: 'Poppins-Regular',
  },
  logo: {
    width: wp('12%'),
    height: wp('12%'),
    resizeMode: 'contain',
    left: wp('10%'),
  },

  topRow: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    width: wp('90%'),
    marginTop: hp('2%'),
  },

  box: {
    width: wp('42%'),
    backgroundColor: '#f8f8f8',
    padding: hp('2.5%'),
    borderRadius: wp('2%'),
    alignItems: 'center',
  },

  boxImg: { width: wp('20%'), height: wp('20%'), resizeMode: 'contain' },
  boxText: {
    marginTop: hp('2%'),
    fontSize: RFPercentage(1.6),
    fontFamily: 'Poppins-SemiBold',
    textAlign: 'center',
  },

  profileWrapper: {
    width: wp('90%'),
    alignSelf: 'center',
    marginTop: hp('7%'),
    alignItems: 'center',
  },

  profileImageContainer: {
    width: wp('22%'),
    height: wp('22%'),
    borderRadius: wp('50%'),
    backgroundColor: '#fff',
    justifyContent: 'center',
    alignItems: 'center',
    elevation: 5,
    position: 'absolute',
    top: hp('-5%'),
    borderWidth: 2,
    borderColor: '#fff',
    zIndex: 10,
  },

  profileImage: {
    width: wp('18%'),
    height: wp('18%'),
    borderRadius: wp('50%'),
    resizeMode: 'cover',
  },

  cardContainer: {
    width: '100%',
    backgroundColor: '#E6F9FA',
    paddingTop: hp('8%'),
    paddingBottom: hp('3%'),
    paddingHorizontal: wp('5%'),
    borderRadius: wp('2%'),
    alignItems: 'center',
  },

  cardTitle: {
    fontSize: RFPercentage(2.5),
    fontFamily: 'Poppins-SemiBold',
  },

  cardRow: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    width: '100%',
    marginTop: hp('2%'),
  },

  col: { width: '48%' },

  label: {
    fontSize: RFPercentage(1.6),
    color: '#444',
    fontWeight: '500',
    fontFamily: 'Poppins-Regular',
  },
  value: {
    fontSize: RFPercentage(2),
    fontWeight: '600',
    fontFamily: 'Poppins-Regular',
  },
  schoolcardWrapper: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    width: wp('90%'),
    marginTop: hp('2%'),
    alignContent: 'center',
    alignSelf: 'center',
  },
  schoolcard: {
    width: wp('42%'),
    height: hp('20%'),
    backgroundColor: '#f8f8f8',
    padding: hp('2.5%'),
    borderRadius: wp('2%'),
    alignItems: 'center',
  },
  schoolcard2: {
    width: wp('42%'),
    height: hp('20%'),
    backgroundColor: '#f8f8f8',
    padding: hp('2.5%'),
    borderRadius: wp('2%'),
    alignItems: 'center',
  },
  sectionTitle: {
    marginTop: hp('5%'),
    fontSize: RFPercentage(2),
    fontWeight: '500',
    textAlign: 'center',
    color: '#fff',
    fontFamily: 'Poppins-Regular',
  },
  flag: {
    width: wp('18%'),
    height: wp('10%'),
    marginRight: wp('4%'),
    borderRadius: 5,
  },
  Abrod: {
    marginVertical: hp('1%'),
    fontSize: RFPercentage(2),
    fontWeight: '500',
    textAlign: 'center',
    fontFamily: 'Poppins-SemiBold',
  },
  FlatListView: {
    marginTop: hp('2%'),
    marginBottom: hp('3%'),
    alignContent: 'center',
    alignSelf: 'center',
    justifyContent: 'center',
    flex: 1,
  },
  containerTes: {
    alignItems: 'center',
    flex: 1,
    marginBottom: hp('10%'),
  },

  heading: {
    fontSize: 20,
    marginBottom: 15,
    fontFamily: 'Poppins-SemiBold',
  },

  card: {
    // borderRadius: 15,
    marginRight: 15,
    alignItems: 'center',
    borderRadius: 20,
  },

  avatar: {
    width: 60,
    height: 60,
    borderRadius: 30,
    alignSelf: 'center',
    marginBottom: 10,
  },

  title: {
    fontSize: 16,
    color: '#000',
    fontFamily: 'Poppins-Regular',
  },

  subtitle: {
    fontSize: 12,
    color: '#444',
    marginBottom: 10,
    fontFamily: 'Poppins-Regular',
  },

  desc: {
    textAlign: 'left',
    fontSize: 13,
    color: '#555',
    marginTop: 5,
    fontFamily: 'Poppins-Regular',
  },
  header: {
    paddingHorizontal: 15,
    flexDirection: 'row',
    justifyContent: 'space-between',
  },
});
