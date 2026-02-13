import {
  View,
  Text,
  StyleSheet,
  StatusBar,
  TouchableOpacity,
  TextInput,
  FlatList,
  Image,
  Linking
} from 'react-native';
import React, { useEffect, useState } from 'react';
import Icon from 'react-native-vector-icons/Ionicons';
import { useNavigation } from '@react-navigation/native';
import { SafeAreaView } from 'react-native-safe-area-context';
import {
  widthPercentageToDP as wp,
  heightPercentageToDP as hp,
} from 'react-native-responsive-screen';
import { RFPercentage } from 'react-native-responsive-fontsize';
import { getApi, BASE_URL } from '../config/api';

const ExpertTips = () => {
  const navigation = useNavigation();
  const [expertTips, setExpertTips] = useState([]);

  const getExpertTips = async () => {
    try {
      const res = await getApi('/get-expert-tips');
      setExpertTips(res?.data || []);
    } catch (error) {
      console.log('Error fetching expert tips:', error);
    }
  };

  useEffect(() => {
    getExpertTips();
  }, []);

  const getImageUrl = thumbnail => {
    if (!thumbnail) return null;
    return thumbnail.startsWith('http')
      ? thumbnail
      : `${BASE_URL}/${thumbnail}`;
  };

  return (
    <SafeAreaView style={styles.container}>
      <StatusBar barStyle="dark-content" backgroundColor="#fff" />

      {/* HEADER */}
      <View style={styles.header}>
        <TouchableOpacity
          style={styles.backBtn}
          onPress={() => navigation.goBack()}
        >
          <Icon name="arrow-back" size={22} color="#fff" />
        </TouchableOpacity>

        <Text style={styles.headerTitle}>Expert Tips</Text>
        <View />
      </View>

      {/* SEARCH BAR */}
      <View style={styles.searchContainer}>
        <Icon name="search-outline" size={22} color="#2D6EFF" />

        <TextInput
          placeholder="Search Videos"
          placeholderTextColor="#666"
          style={styles.input}
        />

        <TouchableOpacity>
          <Icon name="filter-outline" size={22} color="#2D6EFF" />
        </TouchableOpacity>
      </View>

      {/* LIST */}
      <FlatList
        data={expertTips}
        numColumns={2}
        keyExtractor={item => item.id?.toString()}
        columnWrapperStyle={styles.columnWrapper}
        contentContainerStyle={styles.listContent}
        showsVerticalScrollIndicator={false}
        renderItem={({ item }) => {
          const imageUrl = getImageUrl(item.thumbnail);

          return (
            <TouchableOpacity
              style={styles.card}
              onPress={() => {
                if (item.video_link) {
                  Linking.openURL(item.video_link);
                }
              }}
            >
              <View style={styles.imageWrapper}>
                <Image
                  source={
                    imageUrl
                      ? { uri: imageUrl }
                      : require('../assets/Image/Video1.png')
                  }
                  style={styles.cardImage}
                  resizeMode="contain"
                />
              </View>

              {/* TITLE */}
              <Text style={styles.title} numberOfLines={2}>
                {item.title}
              </Text>
            </TouchableOpacity>
          );
        }}
      />
    </SafeAreaView>
  );
};

export default ExpertTips;

/* ================= STYLES ================= */

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#fff',
  },

  header: {
    flexDirection: 'row',
    alignItems: 'center',
    paddingHorizontal: wp('4%'),
    marginTop: hp('2%'),
    justifyContent: "space-between"
  },

  backBtn: {
    width: wp('10%'),
    height: wp('10%'),
    borderRadius: wp('5%'),
    backgroundColor: '#2D6EFF',
    justifyContent: 'center',
    alignItems: 'center',
  },

  headerTitle: {
    marginLeft: wp('4%'),
    fontSize: RFPercentage(2.4),
    color: '#000',
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
    marginTop: hp('2%'),
  },

  input: {
    flex: 1,
    fontSize: RFPercentage(2),
    marginHorizontal: wp('2%'),
    color: '#000',
    fontFamily: 'Poppins-Regular',
  },

  listContent: {
    paddingBottom: hp('3%'),
    marginTop: hp('2%'),
  },

  columnWrapper: {
    justifyContent: 'space-between',
    paddingHorizontal: wp('5%'),
  },

  card: {
    width: wp('40%'),
    marginBottom: hp('3%'),
  },

  imageWrapper: {
    width: '100%',
    height: hp('12%'),
    borderRadius: wp('3%'),
    overflow: 'hidden',
    backgroundColor: '#EAEAEA',
  },

  cardImage: {
    width: '100%',
    height: '100%',
  },

  title: {
    marginTop: hp('1%'),
    fontSize: RFPercentage(2),
    color: '#000',
    fontFamily: 'Poppins-SemiBold',
  },
});
