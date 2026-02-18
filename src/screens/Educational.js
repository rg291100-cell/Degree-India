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
      const data = await getApi('/news/education/latest?limit=10', false);
      setNews(data.data || []);
    } catch (error) {
      console.log('ERROR =>', error.message);
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

  const filteredNews = news.filter(item =>
    item.title?.toLowerCase().includes(search.toLowerCase()) ||
    item.description?.toLowerCase().includes(search.toLowerCase())
  );

  const displayNews = (filteredNews.length > 0 ? filteredNews : [
    {
      id: "d1",
      title: "Feature Of Software Engineering",
      description: "Join our team as a Software Engineering Intern and contribute to cutting-edge projects in a dynamic environment.\n\nJoin our team as a Software Engineering Intern and contribute to cutting-edge projects in a dynamic environment.\n\nJoin our team as a Software Engineering Intern and contribute to cutting-edge projects in a dynamic environment.",
      author: "Hr Manager",
      created_at: "15-sep-2025",
      source: "Sources",
      image_url: "https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?q=80&w=800&auto=format&fit=crop",
      authorImage: "https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?q=80&w=200&h=200&auto=format&fit=crop"
    }
  ]);

  return (
    <SafeAreaView style={styles.container}>
      <StatusBar barStyle="dark-content" backgroundColor="#fff" />

      {/* HEADER - Matches Screenshot */}
      <View style={styles.header}>
        <TouchableOpacity
          style={styles.backCircle}
          onPress={() => navigation.goBack()}
        >
          <Icon name="arrow-back" size={22} color="#fff" />
        </TouchableOpacity>
        <Text style={styles.headerTitle}>Educational News</Text>
        <View style={{ width: 40 }} />
      </View>

      {/* SEARCH BAR - Light Teal Theme */}
      <View style={styles.searchRow}>
        <View style={styles.searchFieldBox}>
          <Icon name="search-outline" size={22} color="#00BDD6" />
          <TextInput
            placeholder="Search News"
            placeholderTextColor="#555"
            style={styles.searchTextInput}
            value={search}
            onChangeText={setSearch}
          />
          <TouchableOpacity>
            <Icon name="filter" size={24} color="#00BDD6" />
          </TouchableOpacity>
        </View>
      </View>

      <ScrollView showsVerticalScrollIndicator={false} contentContainerStyle={{ paddingBottom: 30 }}>
        {loading ? (
          <View style={styles.loaderBox}>
            <ActivityIndicator size="large" color="#00BDD6" />
          </View>
        ) : (
          displayNews.map((item, index) => (
            <View key={item.id || index} style={styles.socialCard}>
              {/* Author Row */}
              <View style={styles.authorRow}>
                <Image
                  source={typeof item.authorImage === 'string' ? { uri: item.authorImage } : (item.authorImage || require("../assets/Image/Profile.png"))}
                  style={styles.authorCircle}
                />
                <View style={styles.authorInfo}>
                  <Text style={styles.roleText}>{item.author || 'Hr Manager'}</Text>
                  <Text style={styles.dateText}>{item.created_at || '15-sep-2025'}</Text>
                  <Text style={styles.sourceText}>{item.source || 'Sources'}</Text>
                </View>
              </View>

              {/* Text Content */}
              <View style={styles.cardPadding}>
                <Text style={styles.headlineText}>{item.title}</Text>
                <Text style={styles.bodyText}>{item.description}</Text>
              </View>

              {/* Featured Image */}
              <Image
                source={item.localImage ? item.localImage : (getImageUrl(item.image_url || item.image) ? { uri: getImageUrl(item.image_url || item.image) } : require("../assets/Image/Educational.png"))}
                style={styles.newsImage}
              />

              {/* Bottom Interaction Bar */}
              <View style={styles.interactionBar}>
                <TouchableOpacity style={styles.actionItem}>
                  <Icon name="heart" size={24} color="#FF4D4D" />
                </TouchableOpacity>
                <TouchableOpacity style={styles.actionItem}>
                  <Icon name="chatbubble" size={20} color="#000" />
                </TouchableOpacity>
                <TouchableOpacity style={styles.actionItem}>
                  <Icon name="download-outline" size={22} color="#000" />
                </TouchableOpacity>
                <TouchableOpacity style={styles.actionItem}>
                  <Icon name="share-social-outline" size={22} color="#000" />
                </TouchableOpacity>
              </View>
            </View>
          ))
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
    justifyContent: "space-between",
    paddingHorizontal: 20,
    marginTop: 10,
    marginBottom: 20,
  },
  backCircle: {
    width: 42,
    height: 42,
    borderRadius: 21,
    backgroundColor: "#00BDD6",
    justifyContent: "center",
    alignItems: "center",
    elevation: 3,
  },
  headerTitle: {
    fontSize: 22,
    fontFamily: 'Poppins-Bold',
    color: "#444",
  },
  searchRow: {
    paddingHorizontal: 20,
    marginBottom: 25,
  },
  searchFieldBox: {
    flexDirection: "row",
    alignItems: "center",
    backgroundColor: "#E0F7FA",
    height: 55,
    borderRadius: 12,
    paddingHorizontal: 15,
  },
  searchTextInput: {
    flex: 1,
    fontSize: 16,
    color: "#333",
    fontFamily: 'Poppins-Medium',
    marginLeft: 10,
  },
  socialCard: {
    backgroundColor: '#fff',
    marginBottom: 20,
  },
  authorRow: {
    flexDirection: 'row',
    alignItems: 'center',
    paddingHorizontal: 20,
    marginBottom: 15,
  },
  authorCircle: {
    width: 65,
    height: 65,
    borderRadius: 33,
    backgroundColor: '#f0f0f0',
  },
  authorInfo: {
    marginLeft: 15,
  },
  roleText: {
    fontSize: 12,
    fontFamily: 'Poppins-Bold',
    color: '#333',
  },
  dateText: {
    fontSize: 10,
    fontFamily: 'Poppins-Medium',
    color: '#666',
  },
  sourceText: {
    fontSize: 10,
    fontFamily: 'Poppins-Medium',
    color: '#666',
  },
  cardPadding: {
    paddingHorizontal: 20,
  },
  headlineText: {
    fontSize: 18,
    fontFamily: 'Poppins-Bold',
    color: '#222',
    lineHeight: 24,
    marginBottom: 10,
  },
  bodyText: {
    fontSize: 13,
    fontFamily: 'Poppins-Regular',
    color: '#444',
    lineHeight: 20,
    marginBottom: 15,
  },
  newsImage: {
    width: wp('90%'),
    height: 220,
    alignSelf: 'center',
    borderRadius: 12,
  },
  interactionBar: {
    flexDirection: 'row',
    justifyContent: 'space-around',
    alignItems: 'center',
    width: wp('90%'),
    height: 50,
    backgroundColor: '#fff',
    alignSelf: 'center',
    marginTop: 10,
    borderWidth: 1,
    borderColor: '#eee',
    borderRadius: 10,
  },
  actionItem: {
    flex: 1,
    height: '100%',
    justifyContent: 'center',
    alignItems: 'center',
  },
  loaderBox: {
    marginTop: 50,
    alignItems: 'center',
  }
});
