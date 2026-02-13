import {
  View,
  Text,
  StyleSheet,
  StatusBar,
  TouchableOpacity,
  TextInput,
  ScrollView,
  Image,
  Dimensions,
  ActivityIndicator
} from 'react-native';
import React, { useState, useEffect } from 'react';
import Icon from "react-native-vector-icons/Ionicons";
import { useNavigation } from "@react-navigation/native";
import { SafeAreaView } from 'react-native-safe-area-context';
import {
  widthPercentageToDP as wp,
  heightPercentageToDP as hp,
} from "react-native-responsive-screen";
import { RFPercentage } from "react-native-responsive-fontsize";
import { BASE_IMAGE_URL, getApi } from '../config/api';

const { width } = Dimensions.get('window');

const Educational = () => {
  const navigation = useNavigation();
  const [news, setNews] = useState([]);
  const [loading, setLoading] = useState(false);
  const [search, setSearch] = useState('');

  const getLatestEducationNews = async () => {
    try {
      setLoading(true);
      // ✅ FIX: Remove auth flag - this is a public endpoint
      const data = await getApi('/news/education/latest?limit=10', false);
      console.log('News Data:', data);
      setNews(data.data || []);
    } catch (error) {
      console.log(
        'ERROR =>',
        error.response?.data || error.message
      );
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    getLatestEducationNews()
  }, []);

  const getImageUrl = (url) => {
    if (!url) return null;
    return url.startsWith('http') ? url : `${BASE_IMAGE_URL}${url}`;
  };

  // Filter news
  const filteredNews = news.filter(item =>
    item.title?.toLowerCase().includes(search.toLowerCase()) ||
    item.description?.toLowerCase().includes(search.toLowerCase())
  );

  return (
    <SafeAreaView style={styles.container}>
      <StatusBar barStyle="dark-content" backgroundColor="#fff" />

      {/* HEADER */}
      <View style={styles.header}>
        <TouchableOpacity
          style={styles.backBtn}
          onPress={() => navigation.goBack()}
        >
          <Icon name="arrow-back" size={24} color="#fff" />
        </TouchableOpacity>

        <Text style={styles.headerTitle}>Educational News</Text>
        <View />
      </View>

      {/* SEARCH BAR */}
      <View style={styles.searchContainer}>
        <Icon name="search-outline" size={22} color="#2D6EFF" />
        <TextInput
          placeholder="Search News"
          placeholderTextColor="#555"
          style={styles.input}
          value={search}
          onChangeText={setSearch}
        />
        <TouchableOpacity>
          <Icon name="filter" size={22} color="#2D6EFF" />
        </TouchableOpacity>
      </View>

      <ScrollView showsVerticalScrollIndicator={false}>
        {loading ? (
          <View style={{ marginTop: 50 }}>
            <ActivityIndicator size="large" color="#2D6EFF" />
            <Text style={{ textAlign: 'center', marginTop: 10 }}>Loading news...</Text>
          </View>
        ) : filteredNews.length > 0 ? (
          filteredNews.map((item, index) => (
            <View key={item.id || index} style={styles.newsCard}>
              {/* Top Profile Section */}
              <View style={styles.profileRow}>
                <Image
                  source={require("../assets/Image/Profile.png")} // Fallback or author image
                  style={styles.profileImg}
                />
                <View>
                  <Text style={styles.profileName}>{item.author || 'Admin'}</Text>
                  <Text style={styles.profileDate}>{item.created_at ? new Date(item.created_at).toDateString() : 'Just now'}</Text>
                </View>
              </View>

              {/* Title */}
              <Text style={styles.title}>{item.title}</Text>

              {/* Description */}
              <Text style={styles.desc} numberOfLines={3}>
                {item.description || item.content}
              </Text>

              {/* Featured Image */}
              {getImageUrl(item.image_url || item.image) && (
                <Image
                  source={{ uri: getImageUrl(item.image_url || item.image) }}
                  style={styles.featuredImage}
                />
              )}

              {/* Bottom Tab Bar */}
              <View style={styles.bottomBar}>
                <TouchableOpacity>
                  <Icon name="heart-outline" size={24} color="#000" />
                </TouchableOpacity>

                <TouchableOpacity>
                  <Icon name="chatbubble-ellipses-outline" size={24} color="#000" />
                </TouchableOpacity>

                <TouchableOpacity>
                  <Icon name="share-social-outline" size={24} color="#000" />
                </TouchableOpacity>

                <TouchableOpacity>
                  <Icon name="bookmark-outline" size={24} color="#000" />
                </TouchableOpacity>
              </View>
            </View>
          ))
        ) : (
          <Text style={{ textAlign: 'center', marginTop: 50, color: '#666' }}>No news found.</Text>
        )}
      </ScrollView>
    </SafeAreaView>
  );
};

export default Educational;

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: "#fff",
  },
  header: {
    flexDirection: "row",
    alignItems: "center",
    paddingHorizontal: wp("4%"),
    marginTop: hp("2%"),
    marginBottom: hp("1%"),
    justifyContent: "space-between"
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
    fontSize: RFPercentage(2.4),
    fontFamily: 'Poppins-SemiBold',
    color: "#000",
    marginLeft: wp("4%"),
  },
  searchContainer: {
    flexDirection: "row",
    alignItems: "center",
    width: wp("90%"),
    height: hp("6%"),
    backgroundColor: "#EEF2FF",
    borderRadius: wp("3%"),
    alignSelf: "center",
    paddingHorizontal: wp("3%"),
    marginTop: hp("2%"),
    justifyContent: "space-between",
    marginBottom: 20
  },
  input: {
    flex: 1,
    fontSize: RFPercentage(2),
    marginHorizontal: wp("2%"),
    color: "#000",
    fontFamily: 'Poppins-Regular',
  },
  newsCard: {
    borderBottomWidth: 1,
    borderBottomColor: '#eee',
    paddingBottom: 20,
    marginBottom: 20
  },
  profileRow: {
    flexDirection: "row",
    alignItems: "center",
    paddingHorizontal: wp("5%"),
    marginBottom: 10
  },
  profileImg: {
    width: wp("10%"),
    height: wp("10%"),
    borderRadius: wp("5%"),
    marginRight: wp("3%"),
  },
  profileName: {
    fontSize: RFPercentage(1.8),
    fontWeight: "600",
    color: "#000",
    fontFamily: 'Poppins-Regular',
  },
  profileDate: {
    fontSize: RFPercentage(1.5),
    color: "#555",
  },
  title: {
    fontSize: RFPercentage(2.2),
    fontFamily: 'Poppins-SemiBold',
    color: "#000",
    paddingHorizontal: wp("5%"),
    marginBottom: hp("1%"),
  },
  desc: {
    fontSize: RFPercentage(1.8),
    color: "#444",
    lineHeight: 24,
    paddingHorizontal: wp("5%"),
    marginBottom: hp("1%"),
    fontFamily: 'Poppins-Regular',
  },
  featuredImage: {
    width: wp("90%"),
    height: hp("25%"),
    alignSelf: "center",
    borderRadius: wp("3%"),
    marginVertical: hp("2%"),
    resizeMode: "cover",
  },
  bottomBar: {
    flexDirection: "row",
    justifyContent: "space-around",
    alignItems: "center",
    width: wp("90%"),
    height: hp("6%"),
    backgroundColor: "#fff",
    borderRadius: wp("3%"),
    alignSelf: "center",
    // elevation: 2,
    // shadowColor: "#000",
    // shadowOpacity: 0.05,
    // shadowOffset: { width: 0, height: 1 },
    borderTopWidth: 1,
    borderTopColor: '#f0f0f0',
    marginTop: 10
  },
});
