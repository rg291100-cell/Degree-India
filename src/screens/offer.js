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

  // 🔹 Fetch offers
  const fetchOffers = async () => {
    try {
      setLoading(true);
      const data = await getApi('/offers');
      console.log('Offers response:', data);
      setOffers(data?.all_offers || data?.data?.all_offers || []);
    } catch (error) {
      console.error('Error fetching offers:', error);
      Alert.alert('Error', 'Unable to fetch offers.');
    } finally {
      setLoading(false);
    }
  };

  // 🔹 Pull to refresh
  const onRefresh = async () => {
    setRefreshing(true);
    await fetchOffers();
    setRefreshing(false);
  };

  useEffect(() => {
    fetchOffers();
  }, []);

  const renderOfferItem = ({ item }) => (
    <TouchableOpacity
      style={styles.offerCard}
      activeOpacity={0.8}
      onPress={() => navigation.navigate('DAnimation', { data: item })}
    >
      {/* Banner/Thumbnail */}
      {item.banner || item.thumbnail ? (
        <Image
          source={{ uri: `${BASE_IMAGE_URL}${item.banner || item.thumbnail}` }}
          style={styles.offerImage}
          resizeMode="cover"
        />
      ) : (
        <View style={[styles.offerImage, styles.placeholderImage]}>
          <Icon name="school" size={50} color="#ccc" />
        </View>
      )}

      <View style={styles.offerContent}>
        {/* Course Title */}
        <Text style={styles.courseTitle} numberOfLines={2}>
          {item.course_title}
        </Text>

        {/* College Name */}
        <View style={styles.infoRow}>
          <Icon name="business" size={14} color="#666" />
          <Text style={styles.collegeName} numberOfLines={1}>
            {item.college_name}
          </Text>
        </View>

        {/* Category & Mode */}
        <View style={styles.tagsContainer}>
          <View style={styles.tag}>
            <Text style={styles.tagText}>{item.category_name}</Text>
          </View>
          <View style={[styles.tag, { backgroundColor: '#E3F2FD' }]}>
            <Text style={[styles.tagText, { color: '#1976D2' }]}>
              {item.course_mode?.toUpperCase()}
            </Text>
          </View>
        </View>

        {/* Duration & Type */}
        <View style={styles.detailsRow}>
          <View style={styles.detailItem}>
            <Icon name="access-time" size={14} color="#666" />
            <Text style={styles.detailText}>{item.duration}</Text>
          </View>
          <View style={styles.detailItem}>
            <Icon name="card-membership" size={14} color="#666" />
            <Text style={styles.detailText}>{item.course_type}</Text>
          </View>
        </View>

        {/* Pricing Section */}
        <View style={styles.pricingSection}>
          {/* Discount Badge */}
          {item.discount_percentage > 0 && (
            <View style={styles.discountBadge}>
              <Text style={styles.discountText}>
                {item.discount_percentage}% OFF
              </Text>
            </View>
          )}

          {/* Prices */}
          <View style={styles.priceContainer}>
            <View>
              <Text style={styles.originalPrice}>
                {item.currency} {parseFloat(item.fees).toLocaleString()}
              </Text>
              <Text style={styles.discountedPrice}>
                {item.currency} {parseFloat(item.discounted_fees).toLocaleString()}
              </Text>
            </View>

            <View style={styles.savingsBox}>
              <Text style={styles.savingsLabel}>You Save</Text>
              <Text style={styles.savingsAmount}>
                {item.currency} {parseFloat(item.savings_amount).toLocaleString()}
              </Text>
            </View>
          </View>

          {/* Admission Fee */}
          <View style={styles.admissionFeeRow}>
            <Text style={styles.admissionLabel}>Admission Fee:</Text>
            <Text style={styles.admissionFee}>
              {item.currency} {parseFloat(item.admission_fee).toLocaleString()}
            </Text>
          </View>

          {/* Total Fees */}
          <View style={styles.totalFeesBox}>
            <Text style={[styles.totalLabel, {
              fontFamily: 'Poppins-Regular',
            }]}>Total with Admission:</Text>
            <Text style={styles.totalFees}>
              {item.currency} {parseFloat(item.total_fees_with_admission).toLocaleString()}
            </Text>
          </View>
        </View>
      </View>
    </TouchableOpacity>
  );

  return (
    <SafeAreaView style={styles.container}>
      {/* Header */}
      <View style={styles.header}>
        {/* <TouchableOpacity onPress={() => navigation.goBack()}>
          <Icon name="arrow-back" size={24} color="#000" />
        </TouchableOpacity> */}
        <View />
        <Text style={styles.headerTitle}>Special Offers</Text>
        <View style={{ width: 24 }} />
      </View>

      {/* Content */}
      {loading && !refreshing ? (
        <View style={styles.loadingContainer}>
          <ActivityIndicator size="large" color="#2196F3" />
          <Text style={styles.loadingText}>Loading offers...</Text>
        </View>
      ) : offers.length > 0 ? (
        <FlatList
          data={offers}
          renderItem={renderOfferItem}
          keyExtractor={(item, index) =>
            `${item.course_id}-${item.college_id}-${index}`
          }
          contentContainerStyle={styles.listContent}
          showsVerticalScrollIndicator={false}
          refreshControl={
            <RefreshControl refreshing={refreshing} onRefresh={onRefresh} />
          }
        />
      ) : (
        <View style={styles.emptyContainer}>
          <Icon name="local-offer" size={80} color="#ccc" />
          <Text style={styles.emptyText}>No offers available</Text>
          <TouchableOpacity style={styles.retryButton} onPress={fetchOffers}>
            <Text style={styles.retryText}>Retry</Text>
          </TouchableOpacity>
        </View>
      )}
    </SafeAreaView>
  );
};

export default Offer;

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#f5f5f5',
  },
  header: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    paddingHorizontal: 16,
    paddingVertical: 12,
    // backgroundColor: '#fff',
    borderBottomWidth: 1,
    borderBottomColor: '#eee',
  },
  headerTitle: {
    fontSize: 18,
    fontFamily: 'Poppins-SemiBold',
    color: '#000',
  },
  loadingContainer: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
  },
  loadingText: {
    marginTop: 10,
    fontSize: 14,
    fontFamily: 'Poppins-Regular',
    color: '#666',
  },
  listContent: {
    padding: 16,
  },
  offerCard: {
    backgroundColor: '#fff',
    borderRadius: 12,
    marginBottom: 16,
    overflow: 'hidden',
    elevation: 3,
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 2 },
    shadowOpacity: 0.1,
    shadowRadius: 4,
  },
  offerImage: {
    width: '100%',
    height: 180,
    backgroundColor: '#eee',
  },
  placeholderImage: {
    justifyContent: 'center',
    alignItems: 'center',
  },
  offerContent: {
    padding: 16,
  },
  courseTitle: {
    fontSize: 18,
    fontFamily: 'Poppins-SemiBold',
    color: '#000',
    marginBottom: 8,
  },
  infoRow: {
    flexDirection: 'row',
    alignItems: 'center',
    marginBottom: 10,
  },
  collegeName: {
    fontSize: 13,
    fontFamily: 'Poppins-Regular',
    color: '#666',
    marginLeft: 6,
    flex: 1,
  },
  tagsContainer: {
    flexDirection: 'row',
    marginBottom: 12,
    gap: 8,
  },
  tag: {
    backgroundColor: '#FFF3E0',
    paddingHorizontal: 10,
    paddingVertical: 4,
    borderRadius: 12,
  },
  tagText: {
    fontSize: 11,
    fontFamily: 'Poppins-Regular',
    color: '#E65100',
  },
  detailsRow: {
    flexDirection: 'row',
    marginBottom: 16,
    gap: 16,
    fontFamily: 'Poppins-Medium',

  },
  detailItem: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: 4,
  },
  detailText: {
    fontSize: 12,
    fontFamily: 'Poppins-Regular',
    color: '#666',
  },
  pricingSection: {
    borderTopWidth: 1,
    borderTopColor: '#eee',
    paddingTop: 12,
    fontFamily: 'Poppins-Regular',

  },
  discountBadge: {
    alignSelf: 'flex-start',
    backgroundColor: '#4CAF50',
    paddingHorizontal: 12,
    paddingVertical: 6,
    borderRadius: 20,
    marginBottom: 12,
  },
  discountText: {
    fontSize: 14,
    fontFamily: 'Poppins-Bold',
    color: '#fff',
  },
  priceContainer: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
    marginBottom: 10,
  },
  originalPrice: {
    fontSize: 14,
    fontFamily: 'Poppins-Regular',
    color: '#999',
    textDecorationLine: 'line-through',
  },
  discountedPrice: {
    fontSize: 22,
    fontFamily: 'Poppins-Bold',
    color: '#2196F3',
  },
  savingsBox: {
    alignItems: 'flex-end',
  },
  savingsLabel: {
    fontSize: 11,
    fontFamily: 'Poppins-Regular',
    color: '#666',
  },
  savingsAmount: {
    fontSize: 16,
    fontFamily: 'Poppins-Regular',
    color: '#4CAF50',
  },
  admissionFeeRow: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
    marginBottom: 8,
  },
  admissionLabel: {
    fontSize: 13,
    fontFamily: 'Poppins-Regular',
    color: '#666',
  },
  admissionFee: {
    fontSize: 14,
    fontFamily: 'Poppins-SemiBold',
    color: '#333',
  },
  totalFeesBox: {
    backgroundColor: '#F5F5F5',
    padding: 12,
    borderRadius: 8,
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
    marginTop: 8,
  },
  totalLabel: {
    fontSize: 13,
    fontFamily: 'Poppins-Regular',
    color: '#333',
  },
  totalFees: {
    fontSize: 18,
    fontFamily: 'Poppins-Regular',
    color: '#E65100',
  },
  emptyContainer: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
    paddingHorizontal: 40,
  },
  emptyText: {
    fontSize: 16,
    fontFamily: 'Poppins-Regular',
    color: '#999',
    marginTop: 16,
    marginBottom: 20,
  },
  retryButton: {
    backgroundColor: '#2196F3',
    paddingHorizontal: 30,
    paddingVertical: 12,
    borderRadius: 8,
  },
  retryText: {
    fontSize: 14,
    fontFamily: 'Poppins-SemiBold',
    color: '#fff',
  },
});