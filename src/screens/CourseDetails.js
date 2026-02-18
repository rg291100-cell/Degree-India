import React, { useEffect, useState } from 'react';
import {
  View,
  Text,
  StyleSheet,
  StatusBar,
  TouchableOpacity,
  ScrollView,
  ActivityIndicator,
  FlatList,
  Image
} from 'react-native';

import {
  widthPercentageToDP as wp,
  heightPercentageToDP as hp,
} from 'react-native-responsive-screen';

import { RFPercentage } from 'react-native-responsive-fontsize';
import Icon from 'react-native-vector-icons/MaterialIcons';
import { SafeAreaView } from 'react-native-safe-area-context';
import { useNavigation, useRoute } from '@react-navigation/native';
import { getApi, BASE_IMAGE_URL } from '../config/api';

const CourseDetails = () => {
  const navigation = useNavigation();
  const route = useRoute();
  const { categoryId, name, slug } = route.params;
  console.log("Cat id", name);

  const [courses, setCourses] = useState([]);
  const [loading, setLoading] = useState(false);

  // Helper for safe image URI
  const getImageUri = (item) => {
    try {
      // Prioritize banner_image as requested by user
      const img = item.banner_image || item.thumbnail_image || item.banner || item.thumbnail || item.image || item.image_url;

      if (!img || typeof img !== 'string') return null;

      // Use the imported BASE_IMAGE_URL
      return img.startsWith('http') ? img : `${BASE_IMAGE_URL}${img}`;
    } catch (e) {
      console.log('Error generating image URI:', e);
      return null;
    }
  };

  // 🔹 Fetch courses by category
  const getCourses = async () => {
    try {
      setLoading(true); // Keep setLoading(true) from original code
      const data = await getApi(`/courses/category/${categoryId}`);
      console.log('Courses Data:', data);

      // Robust array extraction
      let list = [];
      if (Array.isArray(data)) {
        list = data;
      } else if (data?.courses && Array.isArray(data.courses)) {
        list = data.courses;
      } else if (data?.data && Array.isArray(data.data)) {
        list = data.data;
      }

      setCourses(list);
    } catch (error) {
      console.log('Error fetching courses:', error);
      setCourses([]);
    } finally {
      setLoading(false); // Keep setLoading(false) from original code
    }
  };

  useEffect(() => {
    getCourses();
  }, []);

  const handlePress = (item) => {
    navigation.navigate('DAnimation', { data: item });
  }

  const renderItem = ({ item }) => {
    const imageUri = getImageUri(item);
    return (
      <TouchableOpacity onPress={() => handlePress(item)} style={styles.card}>
        <Image
          source={imageUri ? { uri: imageUri } : require('../assets/Icons/Applogo.png')}
          style={styles.courseImage}
        />

        {/* Price Tag */}
        {item.price && (
          <View style={styles.priceTag}>
            <Text style={styles.priceText}>₹ {item.price}</Text>
          </View>
        )}

        {/* Text info */}
        <Text style={styles.title} numberOfLines={2}>{item.title}</Text>

        {item.joined && (
          <Text style={styles.joinText}>{item.joined} Joined</Text>
        )}

        {item.discount && (
          <Text style={styles.discount}>{item.discount}</Text>
        )}
      </TouchableOpacity>
    );
  };

  return (
    <SafeAreaView style={styles.container}>
      <StatusBar backgroundColor="#fff" barStyle="dark-content" />

      {/* ---------- Header ---------- */}
      {/* <Image
        source={require("../assets/Image/DAnimation.png")}
        style={styles.imageStyle}
      /> */}

      {/* HEADER */}
      <View style={styles.header}>
        <TouchableOpacity
          style={styles.backBtn}
          onPress={() => navigation.goBack()}
        >
          <Icon name="arrow-back" size={24} color="#fff" />
        </TouchableOpacity>

        <Text style={styles.headerTitle}>{name}</Text>
        <View />
      </View>

      {/* ---------- Content ---------- */}
      {loading ? (
        <View style={styles.loaderContainer}>
          <ActivityIndicator size="large" color="#2D6EFF" />
          <Text style={styles.loadingText}>Loading courses...</Text>
        </View>
      ) : (
        <FlatList
          data={courses}
          numColumns={2}
          keyExtractor={(item) => item.id.toString()}
          showsVerticalScrollIndicator={false}
          columnWrapperStyle={{ justifyContent: "space-between", marginTop: hp("2%") }}
          contentContainerStyle={{ paddingHorizontal: wp("4%"), paddingBottom: hp("5%") }}
          ListEmptyComponent={
            <Text style={styles.emptyText}>No courses available</Text>
          }
          renderItem={renderItem}


        />
      )}
    </SafeAreaView >
  );
};

export default CourseDetails;

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#fff',
  },

  imageStyle: {
    width: '100%',
    height: hp('25%'),
    resizeMode: 'cover',
  },

  header: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    paddingHorizontal: 16,
    paddingVertical: 12,
    backgroundColor: '#fff',
    borderBottomWidth: 1,
    borderBottomColor: '#eee',
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
    fontSize: RFPercentage(2.4),
    fontWeight: '500',
    fontFamily: 'Poppins-SemiBold',
    // color: '#fff',
  },

  card: {
    width: wp('43%'),
    backgroundColor: '#fff',
    borderRadius: wp('3%'),
    padding: wp('3%'),
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 2 },
    shadowOpacity: 0.1,
    shadowRadius: 4,
    elevation: 3,
  },

  courseImage: {
    width: '100%',
    height: hp('15%'),
    borderRadius: wp('2%'),
    marginBottom: hp('1%'),
  },

  priceTag: {
    position: 'absolute',
    top: wp('5%'),
    right: wp('5%'),
    backgroundColor: '#2D6EFF',
    paddingHorizontal: wp('2%'),
    paddingVertical: hp('0.5%'),
    borderRadius: wp('1%'),
  },

  priceText: {
    color: '#fff',
    fontSize: RFPercentage(1.6),
    fontWeight: '600',
    fontFamily: 'Poppins-SemiBold',
  },

  title: {
    fontSize: RFPercentage(1.9),
    fontWeight: '600',
    color: '#000',
    fontFamily: 'Poppins-SemiBold',
    marginTop: hp('0.5%'),
  },

  joinText: {
    fontSize: RFPercentage(1.5),
    color: '#666',
    fontFamily: 'Poppins-Regular',
    marginTop: hp('0.3%'),
  },

  discount: {
    fontSize: RFPercentage(1.6),
    color: '#2D6EFF',
    fontWeight: '600',
    fontFamily: 'Poppins-SemiBold',
    marginTop: hp('0.5%'),
  },

  emptyText: {
    textAlign: 'center',
    marginTop: hp('10%'),
    fontSize: RFPercentage(2),
    color: '#888',
    fontFamily: 'Poppins-Regular',
  },

  loaderContainer: {
    marginTop: hp('20%'),
    alignItems: 'center',
  },

  loadingText: {
    marginTop: hp('2%'),
    fontSize: RFPercentage(2),
    color: '#000',
    fontFamily: 'Poppins-Regular',
  },
});