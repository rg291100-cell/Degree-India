import React, { useState, useEffect } from 'react';
import {
  View,
  Text,
  StyleSheet,
  FlatList,
  Image,
  TouchableOpacity,
  ActivityIndicator,
  Alert,
  RefreshControl,
  StatusBar,
} from 'react-native';
import { SafeAreaView } from 'react-native-safe-area-context';
import { useNavigation } from '@react-navigation/native';
import Icon from 'react-native-vector-icons/MaterialIcons';
import { getApi, BASE_IMAGE_URL } from '../config/api';

const Offer = () => {
  const navigation = useNavigation();
  const [offers, setOffers] = useState([]);
  const [loading, setLoading] = useState(false);
  const [refreshing, setRefreshing] = useState(false);

  const fetchOffers = async () => {
    try {
      setLoading(true);
      const res = await getApi('/offers');
      const data = res?.data?.all_offers || res?.all_offers || [];
      setOffers(data);
    } catch (error) {
      console.error('Error fetching offers:', error);
      Alert.alert('Error', 'Unable to fetch offers.');
    } finally {
      setLoading(false);
    }
  };

  const onRefresh = async () => {
    setRefreshing(true);
    await fetchOffers();
    setRefreshing(false);
  };

  useEffect(() => {
    fetchOffers();
  }, []);

  const renderOfferItem = ({ item }) => {
    const savings = parseFloat(item.savings_amount) || 0;
    const hasImage = item.banner || item.thumbnail;

    return (
      <TouchableOpacity
        style={styles.voucherCard}
        activeOpacity={0.9}
        onPress={() => navigation.navigate('DAnimation', { data: item })}
      >
        {/* College Name Section - Fully Visible */}
        <View style={styles.collegeHeader}>
          <View style={styles.collegeInfoRow}>
            <View style={styles.verifyIconBox}>
              <Icon name="verified" size={18} color="#00BDD6" />
            </View>
            <Text style={styles.collegeNameFull}>
              {item.college_name || 'Premium Academic Partner'}
            </Text>
          </View>
          <View style={styles.officialBadge}>
            <Text style={styles.officialText}>OFFICIAL</Text>
          </View>
        </View>

        {/* The Ticket Divider */}
        <View style={styles.ticketDivider}>
          <View style={[styles.circleCut, { left: -10 }]} />
          <View style={styles.dashLine} />
          <View style={[styles.circleCut, { right: -10 }]} />
        </View>

        <View style={styles.voucherBody}>
          <View style={styles.bodyContent}>
            <View style={styles.imageWrapper}>
              <Image
                source={
                  hasImage
                    ? { uri: `${BASE_IMAGE_URL}${item.banner || item.thumbnail}` }
                    : require("../assets/Image/Educational.png")
                }
                style={styles.offerThumbnail}
                resizeMode="cover"
              />
              {item.discount_percentage > 0 && (
                <View style={styles.discountTag}>
                  <Text style={styles.discountTagText}>{item.discount_percentage}% OFF</Text>
                </View>
              )}
            </View>

            <View style={styles.detailsBox}>
              <Text style={styles.courseTitleLabel} numberOfLines={2}>
                {item.course_title}
              </Text>

              <View style={styles.infoMeta}>
                <Text style={styles.metaLabelText}>{item.course_mode} • {item.duration}</Text>
              </View>

              <View style={styles.pricingRow}>
                <View>
                  <Text style={styles.currentPrice}>
                    {item.currency} {parseFloat(item.discounted_fees).toLocaleString()}
                  </Text>
                  <Text style={styles.originalPrice}>
                    Reg: {item.currency} {parseFloat(item.fees).toLocaleString()}
                  </Text>
                </View>
                {savings > 0 && (
                  <View style={styles.savingsBoxTag}>
                    <Text style={styles.savingsValue}>SAVE {item.currency}{Math.round(savings)}</Text>
                  </View>
                )}
              </View>
            </View>
          </View>
        </View>
      </TouchableOpacity>
    );
  };

  return (
    <SafeAreaView style={styles.container}>
      <StatusBar backgroundColor="#00BDD6" barStyle="light-content" />

      {/* Premium Header */}
      <View style={styles.appHeader}>

        <View style={styles.headerTitles}>
          <Text style={styles.headerLabel}>Degree India</Text>
          <Text style={styles.headerMain}>Exclusive Admission Offers</Text>
        </View>
        <Icon name="local-activity" size={28} color="#FFD700" />
      </View>

      {loading && !refreshing ? (
        <View style={styles.loaderArea}>
          <ActivityIndicator size="large" color="#00BDD6" />
          <Text style={styles.loaderMsg}>Verifying exclusive deals...</Text>
        </View>
      ) : (
        <FlatList
          data={offers}
          renderItem={renderOfferItem}
          keyExtractor={(item, index) => `${item.course_id}-${item.college_id}-${index}`}
          contentContainerStyle={styles.listPadding}
          showsVerticalScrollIndicator={false}
          refreshControl={
            <RefreshControl refreshing={refreshing} onRefresh={onRefresh} color="#00BDD6" />
          }
        />
      )}
    </SafeAreaView>
  );
};

export default Offer;

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#F4F7FF',
  },
  appHeader: {
    backgroundColor: '#00BDD6',
    paddingTop: 10,
    paddingBottom: 25,
    paddingHorizontal: 20,
    flexDirection: 'row',
    alignItems: 'center',
    borderBottomLeftRadius: 30,
    borderBottomRightRadius: 30,
    elevation: 8,
  },
  backCircle: {
    width: 36,
    height: 36,
    borderRadius: 18,
    backgroundColor: 'rgba(255,255,255,0.2)',
    justifyContent: 'center',
    alignItems: 'center',
    marginRight: 15,
  },
  headerTitles: {
    flex: 1,
  },
  headerLabel: {
    fontSize: 12,
    fontFamily: 'Poppins-Medium',
    color: 'rgba(255,255,255,0.8)',
  },
  headerMain: {
    fontSize: 18,
    fontFamily: 'Poppins-Bold',
    color: '#fff',
    marginTop: -2,
  },
  listPadding: {
    padding: 16,
    paddingBottom: 40,
  },
  voucherCard: {
    backgroundColor: '#fff',
    borderRadius: 24,
    marginBottom: 20,
    overflow: 'hidden',
    elevation: 4,
    shadowColor: '#00BDD6',
    shadowOpacity: 0.1,
    shadowRadius: 10,
    shadowOffset: { width: 0, height: 4 },
  },
  collegeHeader: {
    padding: 16,
    backgroundColor: '#fff',
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'flex-start',
  },
  collegeInfoRow: {
    flex: 1,
    flexDirection: 'row',
    alignItems: 'flex-start',
  },
  verifyIconBox: {
    width: 24,
    height: 24,
    borderRadius: 6,
    backgroundColor: '#EBF2FF',
    justifyContent: 'center',
    alignItems: 'center',
    marginTop: 2,
  },
  collegeNameFull: {
    fontSize: 15,
    fontFamily: 'Poppins-Bold',
    color: '#1A1D1E',
    marginLeft: 10,
    flex: 1,
    lineHeight: 20,
  },
  officialBadge: {
    backgroundColor: '#E7F9ED',
    paddingHorizontal: 8,
    paddingVertical: 4,
    borderRadius: 6,
    borderWidth: 1,
    borderColor: '#2ECC40',
    marginLeft: 10,
  },
  officialText: {
    fontSize: 8,
    fontFamily: 'Poppins-Bold',
    color: '#2ECC40',
  },
  ticketDivider: {
    height: 20,
    flexDirection: 'row',
    alignItems: 'center',
    backgroundColor: '#fff',
    overflow: 'hidden',
  },
  circleCut: {
    width: 20,
    height: 20,
    borderRadius: 10,
    backgroundColor: '#F4F7FF',
    position: 'absolute',
  },
  dashLine: {
    flex: 1,
    height: 1,
    borderWidth: 1.5,
    borderColor: '#F0F2F5',
    borderStyle: 'dashed',
    borderRadius: 1,
    marginHorizontal: 15,
  },
  voucherBody: {
    backgroundColor: '#fff',
    padding: 16,
    paddingTop: 5,
  },
  bodyContent: {
    flexDirection: 'row',
  },
  imageWrapper: {
    width: 90,
    height: 110,
    position: 'relative',
  },
  offerThumbnail: {
    width: '100%',
    height: '100%',
    borderRadius: 16,
  },
  discountTag: {
    position: 'absolute',
    bottom: -5,
    right: -5,
    backgroundColor: '#FF4136',
    paddingHorizontal: 8,
    paddingVertical: 4,
    borderRadius: 8,
    elevation: 3,
  },
  discountTagText: {
    color: '#fff',
    fontSize: 10,
    fontFamily: 'Poppins-Bold',
  },
  detailsBox: {
    flex: 1,
    paddingLeft: 16,
    justifyContent: 'space-between',
  },
  courseTitleLabel: {
    fontSize: 15,
    fontFamily: 'Poppins-SemiBold',
    color: '#334155',
    lineHeight: 20,
  },
  infoMeta: {
    marginVertical: 4,
  },
  metaLabelText: {
    fontSize: 11,
    fontFamily: 'Poppins-Medium',
    color: '#64748B',
    textTransform: 'capitalize',
  },
  pricingRow: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'flex-end',
    marginTop: 8,
  },
  currentPrice: {
    fontSize: 20,
    fontFamily: 'Poppins-Bold',
    color: '#00BDD6',
  },
  originalPrice: {
    fontSize: 10,
    fontFamily: 'Poppins-Medium',
    color: '#94A3B8',
    textDecorationLine: 'line-through',
    marginTop: -4,
  },
  savingsBoxTag: {
    backgroundColor: '#E7F9ED',
    paddingHorizontal: 8,
    paddingVertical: 4,
    borderRadius: 8,
  },
  savingsValue: {
    fontSize: 10,
    fontFamily: 'Poppins-Bold',
    color: '#2ECC40',
  },
  loaderArea: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
  },
  loaderMsg: {
    marginTop: 10,
    color: '#64748B',
    fontFamily: 'Poppins-Medium',
  },
});