import {
  View,
  Text,
  StyleSheet,
  StatusBar,
  Image,
  TouchableOpacity,
  FlatList,
  ScrollView,
  Alert,
  ActivityIndicator,
  Modal,
} from "react-native";
import React, { useState } from "react";
import Icon from "react-native-vector-icons/Ionicons";
import {
  widthPercentageToDP as wp,
  heightPercentageToDP as hp,
} from "react-native-responsive-screen";
import { RFPercentage } from "react-native-responsive-fontsize";
import { SafeAreaView } from 'react-native-safe-area-context';
import { useNavigation, useRoute } from '@react-navigation/native';
import { BASE_IMAGE_URL, postApi } from '../config/api';

const DAnimation = () => {
  const navigation = useNavigation();
  const route = useRoute();
  const { data: courseData } = route.params || {};
  const [enrolling, setEnrolling] = useState(false);
  const [modalVisible, setModalVisible] = useState(false);
  const [modalTitle, setModalTitle] = useState('');
  const [modalMessage, setModalMessage] = useState('');

  // Normalize data fields
  const title = courseData?.course_title || courseData?.title || "Course Details";
  const price = courseData?.discounted_fees || courseData?.price || "N/A";
  const discount = courseData?.discount_percentage || "0";
  const joined = courseData?.joined || "0";
  const rating = courseData?.rating || "4.5/5";
  const courseId = courseData?.course_id || courseData?.id;

  const imageUrl = courseData?.thumbnail_image || courseData?.banner_image || courseData?.banner || courseData?.thumbnail || courseData?.image_url || courseData?.image;

  const finalImage = imageUrl
    ? { uri: imageUrl.startsWith('http') ? imageUrl : `${BASE_IMAGE_URL}${imageUrl}` }
    : require("../assets/Image/DAnimation.png");

  // Log for debugging
  console.log('Final Image URL:', finalImage);

  // ✅ FIX: Handle enrollment via API
  const handleEnrollNow = async () => {
    if (!courseId) {
      Alert.alert('Error', 'Course information is missing. Please try again.');
      return;
    }

    try {
      setEnrolling(true);
      const response = await postApi('/admissions/apply', {
        course_id: courseId,
        payment_mode: 'offline' // Default to offline, can be changed later
      }, true);

      if (response.status) {
        Alert.alert(
          'Enrollment Successful!',
          'Your admission application has been submitted successfully. Our admin team will contact you via email for further process.',
          [
            {
              text: 'View My Admissions',
              onPress: () => navigation.navigate('Admission')
            },
            {
              text: 'OK',
              onPress: () => navigation.goBack()
            }
          ]
        );
      } else {
        Alert.alert('Error', response.message || 'Failed to submit admission application.');
      }
    } catch (error) {
      console.log('Enrollment error:', error);
      Alert.alert(
        'Error',
        error.response?.data?.message || 'Failed to submit admission. Please try again.'
      );
    } finally {
      setEnrolling(false);
    }
  };

  // ✅ FIX: Strip HTML tags from text
  const stripHtmlTags = (html) => {
    if (!html) return '';
    return html.replace(/<[^>]*>/g, '').replace(/&nbsp;/g, ' ').replace(/&amp;/g, '&').replace(/&lt;/g, '<').replace(/&gt;/g, '>').trim();
  };

  // ✅ FIX: Handle course highlight card presses
  const handleCardPress = (cardTitle) => {
    let message = '';

    switch (cardTitle) {
      case 'About Course':
        message = stripHtmlTags(courseData?.description || courseData?.about) || 'Detailed course information will be provided by our team.';
        break;
      case 'Fees & Payment':
        message = `Total Fees: ₹${courseData?.fees || price}\nDiscounted Fees: ₹${price}\nAdmission Fee: ₹${courseData?.admission_fee || 'Contact admin'}\n\nPayment modes: Online/Offline`;
        break;
      case 'Admission Criteria':
        message = stripHtmlTags(courseData?.admission_criteria || courseData?.eligibility) || 'Minimum qualification required. Contact our team for detailed admission criteria.';
        break;
      case 'Talk to Expert':
        message = 'Our expert counselors will contact you shortly to guide you through the admission process. You can also call us at our helpline.';
        break;
      case 'Academic Partners':
        message = courseData?.college_name || courseData?.university || 'This course is offered in partnership with leading educational institutions.';
        break;
      case 'Job Opportunities':
        message = stripHtmlTags(courseData?.job_opportunities || courseData?.career_prospects) || 'Graduates from this course have excellent career opportunities in various sectors.';
        break;
      default:
        message = 'Information will be provided by our team.';
    }

    setModalTitle(cardTitle);
    setModalMessage(message);
    setModalVisible(true);
  };

  const data = [
    {
      id: 1,
      title: "About Course",
      Image: require("../assets/Image/Book1.png"),
      bg: "#E8FFE8",
    },
    {
      id: 2,
      title: "Fees & Payment",
      Image: require("../assets/Image/Book2.png"),
      bg: "#FFE6F7",
    },
    {
      id: 3,
      title: "Admission Criteria",
      Image: require("../assets/Image/Book3.png"),
      bg: "#E0F4FF",
    },
    {
      id: 4,
      title: "Talk to Expert",
      Image: require("../assets/Image/Book1.png"),
      bg: "#E8FFE8",
    },
    {
      id: 5,
      title: "Academic Partners",
      Image: require("../assets/Image/Book2.png"),
      bg: "#FFE6F7",
    },
    {
      id: 6,
      title: "Job Opportunities",
      Image: require("../assets/Image/Book3.png"),
      bg: "#E0F4FF",
    },
  ];

  const ratingData = [
    { star: 5, percent: 0.7 },
    { star: 4, percent: 0.2 },
    { star: 3, percent: 0.05 },
    { star: 2, percent: 0.03 },
    { star: 1, percent: 0.02 },
  ];

  const review = {
    name: "Sophia Bennett",
    time: "2 weeks ago",
    rating: 5,
    text: "This course is fantastic! Dr. Carter explains complex concepts clearly and makes algebra fun. Highly recommend!",
    image: require("../assets/Image/Profile.png"),
  };

  return (
    <SafeAreaView style={styles.safeArea}>
      <StatusBar backgroundColor="#fff" barStyle="dark-content" />

      <ScrollView showsVerticalScrollIndicator={false}>
        {/* TOP IMAGE */}
        {/* TOP IMAGE */}
        <Image
          source={finalImage}
          style={styles.imageStyle}
        />

        {/* HEADER */}
        <View style={styles.header}>
          <TouchableOpacity
            style={styles.backBtn}
            onPress={() => navigation.goBack()}
          >
            <Icon name="arrow-back" size={24} color="#fff" />
          </TouchableOpacity>

          <Text style={styles.headerTitle} numberOfLines={2}>{title}</Text>

          <View style={{ width: 24 }} />
        </View>

        {/* DISCOUNT */}
        <View style={styles.discountview}>
          <Text style={styles.discountText}>Upto {discount}% off</Text>
          <Text style={styles.priceText}>₹{price}</Text>
        </View>

        {/* JOINED / RATING */}
        <View style={styles.ratingview}>
          <Text style={styles.join}>{joined} Joined</Text>
          <Text style={styles.join}>Rating {rating}</Text>
        </View>

        {/* SECTION TITLE */}
        <Text style={styles.title}>Course Highlights</Text>

        {/* DYNAMIC HIGHLIGHTS / GOALS */}
        <View style={styles.GoalView}>
          {(courseData?.course_highlights || courseData?.key_features || []).length > 0 ? (
            (courseData?.course_highlights || courseData?.key_features || []).slice(0, 2).map((goal, index) => {
              // Handle if goal is object {icon, name} or just string
              const label = typeof goal === 'object' ? (goal.name || goal.title || goal.label || 'Goal') : goal;
              // Clean up icon name (remove fa- prefix if present)
              let iconName = typeof goal === 'object' ? (goal.icon || 'checkmark-circle-outline') : 'checkmark-circle-outline';
              if (iconName && iconName.includes('fa-')) {
                iconName = iconName.replace('fa fa-', '').replace('fa-', '').trim();
              }
              // Map some common fa- icons to ionicons if needed, or rely on vector-icons handling

              return (
                <TouchableOpacity key={index} style={styles.ButtonView}>
                  <Icon name={iconName} color="#000" size={20} />
                  <Text style={styles.goaltext} numberOfLines={1}>{label}</Text>
                </TouchableOpacity>
              );
            })
          ) : (
            // Fallback: Show original Define Your Goal buttons if no data
            <>
              <TouchableOpacity style={styles.ButtonView}>
                <Icon name="person-outline" color="#000" size={20} />
                <Text style={styles.goaltext}>Define Your Goal</Text>
              </TouchableOpacity>

              <TouchableOpacity style={styles.ButtonView}>
                <Icon name="person-outline" color="#000" size={20} />
                <Text style={styles.goaltext}>Define Your Goal</Text>
              </TouchableOpacity>
            </>
          )}
        </View>

        {/* GRID CARDS */}
        <FlatList
          data={data}
          numColumns={3}
          keyExtractor={(item) => item.id.toString()}
          scrollEnabled={false}
          columnWrapperStyle={{ justifyContent: "space-evenly" }}
          renderItem={({ item }) => (
            <TouchableOpacity
              style={styles.cardContainer}
              onPress={() => handleCardPress(item.title)}
            >
              <View style={[styles.cardBox, { backgroundColor: item.bg }]}>
                <Image source={item.Image} style={styles.cardIcon} />
              </View>
              <Text style={styles.cardTitle}>{item.title}</Text>
            </TouchableOpacity>
          )}
        />

        {/* ENROLL BUTTON */}
        <TouchableOpacity
          style={[styles.enrollButton, enrolling && { opacity: 0.7 }]}
          onPress={handleEnrollNow}
          disabled={enrolling}
        >
          {enrolling ? (
            <ActivityIndicator color="#fff" />
          ) : (
            <Text style={styles.enrollButtonText}>Enroll Now</Text>
          )}
        </TouchableOpacity>

        {/* RATINGS & REVIEWS SECTION */}
        <View style={styles.container2}>
          <Text style={styles.heading}>Ratings & Reviews</Text>

          <View style={styles.summaryRow}>
            {/* Main Rating */}
            <View>
              <Text style={styles.ratingText}>4.8</Text>

              <View style={styles.starRow}>
                {Array(5)
                  .fill()
                  .map((_, i) => (
                    <Icon
                      key={i}
                      name="star"
                      size={18}
                      color={i < 4 ? "#000" : "#ccc"}
                    />
                  ))}
              </View>

              <Text style={styles.reviewCount}>150 reviews</Text>
            </View>

            {/* Rating Bars */}
            <View style={{ marginLeft: wp("8%") }}>
              {ratingData.map((item) => (
                <View key={item.star} style={styles.ratingBarRow}>
                  <Text style={styles.starLabel}>{item.star}</Text>

                  <View style={styles.barBackground}>
                    <View
                      style={[
                        styles.barFill,
                        { width: `${item.percent * 100}%` },
                      ]}
                    />
                  </View>

                  <Text style={styles.percentText}>
                    {Math.round(item.percent * 100)}%
                  </Text>
                </View>
              ))}
            </View>
          </View>

          {/* Review Card */}
          <View style={styles.reviewCard}>
            <View style={styles.userRow}>
              <Image source={review.image} style={styles.avatar} />
              <View>
                <Text style={styles.userName}>{review.name}</Text>
                <Text style={styles.timeText}>{review.time}</Text>
              </View>
            </View>

            <View style={styles.userStars}>
              {Array(5)
                .fill()
                .map((_, i) => (
                  <Icon
                    key={i}
                    name="star"
                    size={18}
                    color={i < review.rating ? "#000" : "#ccc"}
                  />
                ))}
            </View>

            <Text style={styles.reviewText}>{review.text}</Text>
          </View>
        </View>
      </ScrollView>

      {/* Professional Modal for Course Info */}
      <Modal
        animationType="fade"
        transparent={true}
        visible={modalVisible}
        onRequestClose={() => setModalVisible(false)}
      >
        <View style={styles.modalOverlay}>
          <View style={styles.modalContainer}>
            <View style={styles.modalHeader}>
              <Text style={styles.modalTitle}>{modalTitle}</Text>
              <TouchableOpacity onPress={() => setModalVisible(false)}>
                <Icon name="close" size={24} color="#000" />
              </TouchableOpacity>
            </View>
            <ScrollView style={styles.modalBody} showsVerticalScrollIndicator={false}>
              <Text style={styles.modalMessage}>{modalMessage}</Text>
            </ScrollView>
            <TouchableOpacity
              style={styles.modalButton}
              onPress={() => setModalVisible(false)}
            >
              <Text style={styles.modalButtonText}>OK</Text>
            </TouchableOpacity>
          </View>
        </View>
      </Modal>
    </SafeAreaView>
  );
};

export default DAnimation;
const styles = StyleSheet.create({
  safeArea: {
    flex: 1,
    backgroundColor: '#fff'
  },

  imageStyle: {
    width: wp("100%"),
    height: hp("30%"),
    resizeMode: "cover",
    marginTop: hp("2.5%"),
  },

  header: {
    position: "absolute",
    top: hp("5%"),
    flexDirection: "row",
    alignItems: "center",
    justifyContent: "space-between",
    width: wp("100%"),
    paddingHorizontal: wp("5%"),
  },

  backBtn: {
    width: wp("10%"),
    height: wp("10%"),
    borderRadius: wp("10%"),
    backgroundColor: "#2D6EFF",
    justifyContent: "center",
    alignItems: "center",
  },

  headerTitle: {
    fontSize: RFPercentage(2.5),
    fontWeight: "700",
    color: "#000",
  },
  discountText: {
    fontSize: RFPercentage(2),
    color: "#fff",
    marginTop: hp("2%"),
  },
  priceText: {
    fontSize: RFPercentage(2.5),
    fontWeight: "700",
    color: "#fff",
    marginTop: hp("1%"),
  },
  discountview: {
    // position: 'absolute',
    // backgroundColor: '#FF6B00',
    paddingVertical: hp('0.5%'),
    flexDirection: 'row',
    justifyContent: 'space-between',
    marginTop: hp('-8%'),
    alignContent: 'center',
    width: wp('90%'),
    alignSelf: 'center',
    paddingHorizontal: wp('5%'),
    borderRadius: wp('2%'),
    // backgroundColor: '#FF6B00',
  },
  ratingview: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    marginTop: hp('2%'),
    alignContent: 'center',
    width: wp('90%'),
    alignSelf: 'center',
    paddingHorizontal: wp('5%'),
    marginTop: hp('2%'),
  },
  join: {
    fontSize: RFPercentage(2),
    color: "#000",
    marginTop: hp("1%"),
  },
  title: {
    fontSize: RFPercentage(2.5),
    fontWeight: "700",
    color: "#000",
    marginTop: hp("2%"),
    textAlign: 'center',
  },
  GoalView: {
    marginTop: hp('2%'),
    width: wp('90%'),
    alignSelf: 'center',
    paddingHorizontal: wp('5%'),
    alignContent: 'center',
    flexDirection: 'row',
    justifyContent: 'space-between',
    // height: hp('10%'),
  },
  ButtonView: {
    width: wp('37%'),
    alignSelf: 'center',
    // marginTop: hp('5%'),
    backgroundColor: '#E0E0E0',
    height: hp('5%'),
    left: wp('2%'),
    borderRadius: wp('2%'),
    justifyContent: 'center',
    alignItems: 'center',
    flexDirection: 'row',
    justifyContent: 'space-evenly',
  },
  goaltext: {
    fontSize: RFPercentage(1.5),
    color: "#000",
  },
  CardView: {
    marginTop: hp('2%'),
  },
  FlatListBut: {
    marginTop: hp('2%'),
    flexDirection: 'row',
    alignItems: 'center',
    paddingHorizontal: wp('5%'),
  },
  card: {
    width: wp("28%"),
    height: hp("12%"),
    backgroundColor: "#F3F3F3",
    borderRadius: wp("2%"),
    margin: wp("2%"),
    justifyContent: "center",
    alignItems: "center",
    padding: wp("3%"),
  },

  cardImage: {
    width: wp("10%"),
    height: wp("10%"),
    resizeMode: "contain",
    marginBottom: hp("1%"),
  },

  cardText: {
    fontSize: RFPercentage(1.6),
    textAlign: "center",
    color: "#000",
  },
  cardContainer: {
    alignItems: "center",
    marginBottom: hp("2%"),
    width: wp("30%"),
    marginTop: hp("2%"),
  },

  cardBox: {
    width: wp("25%"),
    height: wp("25%"),
    borderRadius: 15,
    justifyContent: "center",
    alignItems: "center",
  },

  cardIcon: {
    width: wp("9%"),
    height: wp("9%"),
    resizeMode: "contain",
  },

  cardTitle: {
    marginTop: hp("1%"),
    fontSize: RFPercentage(1.7),
    fontWeight: "600",
    textAlign: "center",
    color: "#000",
  },
  enrollButton: {
    backgroundColor: "#000",
    // paddingVertical: hp("1.5%"),
    // paddingHorizontal: wp("5%"),
    width: wp("90%"),
    height: hp("6%"),
    alignSelf: "center",
    justifyContent: "center",
    borderRadius: wp("2%"),
    alignItems: "center",
    marginTop: hp("1%"),
    marginBottom: hp("2%"),
  },
  enrollButtonText: {
    color: "#fff",
    fontSize: RFPercentage(2),
    fontWeight: "700",
  },
  container2: {
    padding: wp("5%"),
  },

  heading: {
    fontSize: 22,
    fontWeight: "700",
    marginBottom: hp("2%"),
    color: "#000",
  },

  summaryRow: {
    flexDirection: "row",
    alignItems: "center",
  },

  ratingText: {
    fontSize: 40,
    fontWeight: "700",
    color: "#000",
  },

  starRow: {
    flexDirection: "row",
    marginVertical: hp("1%"),
  },

  reviewCount: {
    color: "#555",
    fontSize: 15,
  },

  ratingBarRow: {
    flexDirection: "row",
    alignItems: "center",
    marginBottom: hp("1%"),
  },

  starLabel: {
    width: 20,
    fontSize: 15,
    color: "#000",
  },

  barBackground: {
    width: wp("30%"),
    height: 6,
    backgroundColor: "#eee",
    borderRadius: 5,
    overflow: "hidden",
    marginHorizontal: 8,
  },

  barFill: {
    height: "100%",
    backgroundColor: "#000",
  },

  percentText: {
    width: 35,
    textAlign: "right",
    fontSize: 14,
    color: "#000",
  },

  reviewCard: {
    marginTop: hp("3%"),
  },

  userRow: {
    flexDirection: "row",
    alignItems: "center",
    marginBottom: hp("1%"),
  },

  avatar: {
    width: 45,
    height: 45,
    borderRadius: 30,
    marginRight: 10,
  },

  userName: {
    fontSize: 16,
    fontWeight: "700",
    color: "#000",
  },

  timeText: {
    color: "#777",
    fontSize: 13,
  },

  userStars: {
    flexDirection: "row",
    marginVertical: hp("1%"),
  },

  reviewText: {
    color: "#333",
    fontSize: 15,
    lineHeight: 22,
  },

  // Modal Styles
  modalOverlay: {
    flex: 1,
    backgroundColor: 'rgba(0, 0, 0, 0.5)',
    justifyContent: 'center',
    alignItems: 'center',
    padding: 20,
  },
  modalContainer: {
    backgroundColor: '#fff',
    borderRadius: 15,
    width: '100%',
    maxHeight: '80%',
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 2 },
    shadowOpacity: 0.25,
    shadowRadius: 4,
    elevation: 5,
  },
  modalHeader: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
    padding: 20,
    borderBottomWidth: 1,
    borderBottomColor: '#eee',
  },
  modalTitle: {
    fontSize: 18,
    fontWeight: '700',
    color: '#000',
    flex: 1,
  },
  modalBody: {
    padding: 20,
    maxHeight: hp('50%'),
  },
  modalMessage: {
    fontSize: 15,
    color: '#333',
    lineHeight: 22,
  },
  modalButton: {
    backgroundColor: '#000',
    margin: 20,
    marginTop: 10,
    padding: 15,
    borderRadius: 10,
    alignItems: 'center',
  },
  modalButtonText: {
    color: '#fff',
    fontSize: 16,
    fontWeight: '600',
  },

});

