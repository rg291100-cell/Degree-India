
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
  const [profilePic, setProfilePic] = useState(null);
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

  const getProfile = async () => {
    try {
      const data = await getApi('/profile/get');
      setProfilePic(data?.user?.profile_picture || '');
    } catch (error) {
      console.log('Error fetching profile:', error);
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

  const [admissionsList, setAdmissionsList] = useState([]);

  // ... (existing code)

  const getMyAdmissions = async () => {
    try {
      const data = await getApi('/admissions/my-admissions', true);
      // console.log('My Admissions Response:', data);
      if (data?.admissions) {
        setAdmissionsList(data.admissions.slice(0, 1));
        // Keep myAdmission for backward compatibility if used elsewhere, or just use the first one
        setMyAdmission(data.admissions[0] || null);
      }
    } catch (error) {
      console.log('API Error:', error);
    }
  };

  const renderAdmissionCard = ({ item }) => {
    const formatDate = (date) => date ? new Date(date).toLocaleDateString() : 'N/A';

    return (
      <TouchableOpacity
        activeOpacity={0.9}
        onPress={() => navigation.navigate('Admission')}
        style={styles.admissionCardContainer}
      >
        {/* Profile Image overlapping top */}
        <View style={styles.admissionProfileContainer}>
          <Image
            source={{
              uri: profilePic
                ? `${BASE_IMAGE_URL}${profilePic}`
                : 'https://i.pravatar.cc/150?img=3',
            }}
            style={styles.admissionProfileImage}
          />
        </View>

        <Text style={styles.admissionCardTitle}>My Admission Desk</Text>

        <View style={styles.admissionGrid}>
          {/* Row 1 */}
          <View style={styles.admissionRow}>
            <View style={[styles.admissionCol, { flex: 1.5 }]}>
              <View style={{ flexDirection: 'row', alignItems: 'center', marginBottom: 2 }}>
                <Icon name="user-graduate" size={12} color="#444" style={{ width: 20 }} />
                <Text style={styles.admissionLabel}>Course Joined</Text>
              </View>
              <Text style={styles.admissionValue} numberOfLines={1}>
                {item.course?.title || 'Unknown'}
              </Text>
            </View>

            <View style={[styles.admissionCol, { flex: 1 }]}>
              <View style={{ flexDirection: 'row', alignItems: 'center', marginBottom: 2 }}>
                <Icon name="calendar-alt" size={12} color="#444" style={{ width: 20 }} />
                <Text style={styles.admissionLabel}>Date Of Joining</Text>
              </View>
              <Text style={styles.admissionValue}>
                {formatDate(item.admission_date)}
              </Text>
            </View>
          </View>

          <View style={styles.admissionDivider} />

          {/* Row 2 */}
          <View style={styles.admissionRow}>
            <View style={[styles.admissionCol, { flex: 1.5 }]}>
              <View style={{ flexDirection: 'row', alignItems: 'center', marginBottom: 2 }}>
                <Icon name="clock" size={12} color="#444" style={{ width: 20 }} />
                <Text style={styles.admissionLabel}>Duration</Text>
              </View>
              <Text style={styles.admissionValue}>
                {item.course?.duration} {item.course?.duration_unit}
              </Text>
            </View>

            <View style={[styles.admissionCol, { flex: 1 }]}>
              <View style={{ flexDirection: 'row', alignItems: 'center', marginBottom: 2 }}>
                <Icon name="laptop" size={12} color="#444" style={{ width: 20 }} />
                <Text style={styles.admissionLabel}>Learning Module</Text>
              </View>
              <Text style={styles.admissionValue}>
                {item.course?.learning_format || 'Online'}
              </Text>
            </View>
          </View>

          <View style={styles.admissionDivider} />

          {/* Row 3 */}
          <View style={styles.admissionRow}>
            <View style={[styles.admissionCol, { flex: 1.5 }]}>
              <View style={{ flexDirection: 'row', alignItems: 'center', marginBottom: 2 }}>
                <Icon name="hourglass-half" size={12} color="#444" style={{ width: 20 }} />
                <Text style={styles.admissionLabel}>Session / Batch</Text>
              </View>
              <Text style={styles.admissionValue}>
                {item.course?.total_sessions || 'N/A'}
              </Text>
            </View>

            <View style={[styles.admissionCol, { flex: 1 }]}>
              <View style={{ flexDirection: 'row', alignItems: 'center', marginBottom: 2 }}>
                <Icon name="university" size={12} color="#444" style={{ width: 20 }} />
                <Text style={styles.admissionLabel}>Affiliation</Text>
              </View>
              <Text style={styles.admissionValue} numberOfLines={1}>
                {item.college_name || 'Degree India'}
              </Text>
            </View>
          </View>
        </View>

        {/* Bottom Arrow Visual */}
        <View style={{ alignItems: 'center', marginTop: 10 }}>
          <Icon name="chevron-down" size={14} color="#000" />
        </View>

      </TouchableOpacity>
    );
  };

  // ...



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
    getProfile();
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

  // The original renderItem function is no longer used for "Why Join Us"
  // as the FlatList is replaced by a direct map.
  // Keeping it here in case it's used elsewhere, but it's not part of the requested change.
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
              source={
                profilePic
                  ? { uri: `${BASE_IMAGE_URL}${profilePic}` }
                  : require('../assets/Icons/Applogo.png')
              }
              style={{ width: 40, height: 40, borderRadius: 20 }}
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

        {/* My Admission Desk */}
        <View style={{ marginTop: 30, marginBottom: 10 }}>
          {admissionsList.length > 0 ? (
            renderAdmissionCard({ item: admissionsList[0] })
          ) : (
            // Show nothing or prompt if no admission
            <View style={{ paddingHorizontal: 20 }}>
              <View style={[styles.admissionCardContainer, { height: 100, justifyContent: 'center', alignItems: 'center', marginTop: 10 }]}>
                <Text style={{ fontFamily: 'Poppins-Medium', color: '#666' }}>No active admissions found</Text>
              </View>
            </View>
          )}
        </View>

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

          >
            <Image
              source={require('../assets/Image/job.png')}
              style={styles.boxImg}
            />
            <Text style={styles.boxText}>Job & Internships </Text>
          </TouchableOpacity>
        </View>

        <View style={styles.sectionContainer}>
          <View style={styles.sectionHeader}>
            <Text style={styles.sectionTitleDark}>Study Abroad</Text>

          </View>

          <FlatList
            ref={listRef}
            data={Flag}
            horizontal
            showsHorizontalScrollIndicator={false}
            keyExtractor={(item, index) => index.toString()}
            contentContainerStyle={{ paddingHorizontal: 15, paddingVertical: 10 }}
            renderItem={({ item }) => (
              <View style={styles.flagCard}>
                <Image source={item} style={styles.flag} />
              </View>
            )}
          />
        </View>

        <View style={styles.sectionContainer}>
          <Text style={styles.sectionTitleDark}>Testimonials</Text>
          {testimonials.length === 0 && (
            <Text style={styles.emptyText}>No testimonials yet.</Text>
          )}
          <FlatList
            horizontal
            data={testimonials}
            showsHorizontalScrollIndicator={false}
            keyExtractor={item => item.id.toString()}
            contentContainerStyle={{ paddingHorizontal: 15, paddingVertical: 10 }}
            renderItem={({ item }) => (
              <View style={styles.testimonialCard}>
                <View style={styles.testimonialHeader}>
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
                  <View style={styles.testimonialInfo}>
                    <Text style={styles.testimonialName} numberOfLines={1}>
                      {item.title}
                    </Text>
                    <Text style={styles.testimonialRole} numberOfLines={1}>{item.subtitle || 'Student'}</Text>
                  </View>
                </View>
                <View style={styles.divider} />
                <Text style={styles.testimonialText} numberOfLines={4}>
                  "{item.description}"
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
    height: hp('28%'),
    borderRadius: wp('2%'),
  },

  Textview: {
    marginTop: hp('-26%'),
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
    width: wp('44%'),
    backgroundColor: '#F5F7FA', // Light code background
    paddingVertical: hp('2.5%'),
    borderRadius: 12,
    alignItems: 'center',
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 2 },
    shadowOpacity: 0.1,
    shadowRadius: 4,
    elevation: 3,
  },

  boxImg: { width: wp('14%'), height: wp('14%'), resizeMode: 'contain' },

  boxText: {
    marginTop: hp('1.5%'),
    fontSize: RFPercentage(1.7),
    fontFamily: 'Poppins-SemiBold',
    textAlign: 'center',
    color: '#333'
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
    borderRadius: 15, // Updated radius
    alignItems: 'center',
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 2 },
    shadowOpacity: 0.1,
    shadowRadius: 4,
    elevation: 2,
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
    marginTop: hp('2.5%'), // Increased spacing
    alignContent: 'center',
    alignSelf: 'center',
  },
  schoolcard: {
    width: wp('44%'),
    backgroundColor: '#F5F7FA', // Light code background
    paddingVertical: hp('3%'),
    borderRadius: 12,
    alignItems: 'center',
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 2 },
    shadowOpacity: 0.1,
    shadowRadius: 4,
    elevation: 3,
  },
  schoolcard2: {
    width: wp('44%'),
    backgroundColor: '#F5F7FA', // Light code background
    paddingVertical: hp('3%'),
    borderRadius: 12,
    alignItems: 'center',
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 2 },
    shadowOpacity: 0.1,
    shadowRadius: 4,
    elevation: 3,
  },
  sectionTitle: {
    marginTop: hp('5%'),
    fontSize: RFPercentage(2),
    fontWeight: '500',
    textAlign: 'center',
    color: '#fff',
    fontFamily: 'Poppins-Regular',
  },
  whyJoinUsTitle: {
    fontSize: 9,
    marginTop: 5,
    textAlign: 'center',
    color: '#333',
    fontFamily: 'Poppins-Medium',
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

  // New Styles
  sectionContainer: {
    marginTop: hp('2%'),
    width: '100%',
    marginBottom: hp('5%'),
  },
  sectionHeader: {
    flexDirection: 'row',
    justifyContent: 'center',
    alignItems: 'center',
    paddingHorizontal: 15,
    marginBottom: 10,
  },
  sectionTitleDark: {
    fontSize: 18,
    fontWeight: '700',
    color: '#000',
    fontFamily: 'Poppins-SemiBold',
    textAlign: 'center',
    marginBottom: 10,
  },
  seeAllText: {
    fontSize: 14,
    color: '#2D6EFF',
    fontFamily: 'Poppins-Medium',
  },
  flagCard: {
    backgroundColor: '#fff',
    borderRadius: 10,
    padding: 5,
    marginRight: 15,
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 2 },
    shadowOpacity: 0.1,
    shadowRadius: 4,
    elevation: 3,
  },
  flag: {
    width: wp('18%'),
    height: wp('12%'),
    borderRadius: 5,
    resizeMode: 'cover',
  },
  // Testimonial Styles
  testimonialCard: {
    width: wp('75%'),
    backgroundColor: '#fff',
    borderRadius: 15,
    padding: 15,
    marginRight: 15,
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 2 },
    shadowOpacity: 0.1,
    shadowRadius: 4,
    elevation: 3,
    borderWidth: 1,
    borderColor: '#eee',
  },
  testimonialHeader: {
    flexDirection: 'row',
    alignItems: 'center',
    marginBottom: 10,
  },
  testimonialInfo: {
    marginLeft: 12,
    flex: 1,
  },
  testimonialName: {
    fontSize: 16,
    fontWeight: '700',
    color: '#000',
    fontFamily: 'Poppins-SemiBold',
  },
  testimonialRole: {
    fontSize: 12,
    color: '#666',
    fontFamily: 'Poppins-Regular',
  },
  divider: {
    height: 1,
    backgroundColor: '#eee',
    marginVertical: 8,
  },
  testimonialText: {
    fontSize: 13,
    color: '#444',
    fontFamily: 'Poppins-Regular',
    lineHeight: 20,
    fontStyle: 'italic',
  },
  emptyText: {
    fontFamily: 'Poppins-Regular',
    color: '#999',
    marginLeft: 15,
  },
  avatar: {
    width: 50,
    height: 50,
    borderRadius: 25,
    backgroundColor: '#f0f0f0',
  },
  // Admission Card Styles
  admissionCardContainer: {
    width: wp('91%'),
    backgroundColor: '#EEF2FF', // Light blue bg
    borderRadius: 15,
    padding: 15,
    paddingTop: 25, // space for profile image
    marginTop: 20,
    alignSelf: 'center',
    borderWidth: 1,
    borderColor: '#E0E7FF',
    // shadow
    shadowColor: "#000",
    shadowOffset: { width: 0, height: 2 },
    shadowOpacity: 0.1,
    shadowRadius: 3.84,
    elevation: 5,
  },
  admissionProfileContainer: {
    position: 'absolute',
    top: -20,
    alignSelf: 'center',
    backgroundColor: '#fff',
    padding: 3,
    borderRadius: 30,
    elevation: 5,
  },
  admissionProfileImage: {
    width: 50,
    height: 50,
    borderRadius: 25,
  },
  admissionCardTitle: {
    textAlign: 'center',
    fontSize: RFPercentage(2.5),
    fontWeight: '700',
    color: '#000',
    marginTop: 15,
    marginBottom: 15,
    fontFamily: 'Poppins-SemiBold'
  },
  admissionGrid: {
    width: '100%',
  },
  admissionRow: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    marginBottom: 10,
  },
  admissionCol: {
    // flex: 1, // handled inline
  },
  admissionLabel: {
    fontSize: RFPercentage(1.4),
    color: '#666',
    marginLeft: 5,
    fontFamily: 'Poppins-Regular'
  },
  admissionValue: {
    fontSize: RFPercentage(1.6),
    fontWeight: '600',
    color: '#000',
    marginTop: 2,
    fontFamily: 'Poppins-Medium'
  },
  admissionDivider: {
    height: 1,
    backgroundColor: '#D1D9FF',
    marginVertical: 10,
    opacity: 0.5
  },
});
