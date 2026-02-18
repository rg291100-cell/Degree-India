import {
  View,
  Text,
  StatusBar,
  TouchableOpacity,
  StyleSheet,
  Image,
  ScrollView,
  Linking,
  ActivityIndicator
} from "react-native";

import React, { useEffect, useState } from "react";
import Icon from "react-native-vector-icons/Ionicons";
import { useNavigation, useRoute } from "@react-navigation/native";
import { SafeAreaView } from 'react-native-safe-area-context';
import {
  widthPercentageToDP as wp,
  heightPercentageToDP as hp,
} from "react-native-responsive-screen";
import { RFPercentage } from "react-native-responsive-fontsize";
import { BASE_IMAGE_URL, getApi } from '../config/api';

const RML = () => {
  const navigation = useNavigation();
  const route = useRoute();
  const { data: initialData } = route.params || {};

  const [college, setCollege] = useState(initialData || null);
  const [bankDetails, setBankDetails] = useState(null);
  const [loading, setLoading] = useState(true);

  const fetchCollegeDetails = async () => {
    if (!initialData?.id) {
      setLoading(false);
      return;
    }
    try {
      setLoading(true);
      const [res, accRes] = await Promise.all([
        getApi(`/get-college/${initialData.id}`, false),
        getApi(`/account-details/${initialData.id}`, false)
      ]);

      if (res?.success) {
        setCollege(res.college);
      }
      if (accRes?.success && accRes?.data?.length > 0) {
        setBankDetails(accRes.data[0]);
      }
    } catch (error) {
      console.log("Error fetching college details:", error);
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchCollegeDetails();
  }, [initialData?.id]);

  const getImageUrl = (path) => {
    if (!path) return null;
    return path.startsWith('http') ? path : `${BASE_IMAGE_URL}${path}`;
  };

  const stripHtmlTags = (html) => {
    if (!html) return '';
    return html.replace(/<[^>]*>/g, '').replace(/&nbsp;/g, ' ').replace(/\s+/g, ' ').trim();
  };

  const formatCurrency = (val) => {
    if (!val) return "N/A";
    const num = parseFloat(val);
    if (num >= 10000000) return (num / 10000000).toFixed(1) + " Cr";
    if (num >= 100000) return (num / 100000).toFixed(1) + " LPA";
    return num.toLocaleString('en-IN');
  };

  if (loading) {
    return (
      <View style={[styles.container, { justifyContent: 'center', alignItems: 'center' }]}>
        <ActivityIndicator size="large" color="#2D6EFF" />
        <Text style={{ marginTop: 10, fontFamily: 'Poppins-Regular' }}>Loading full details...</Text>
      </View>
    );
  }

  if (!college) {
    return (
      <View style={[styles.container, { justifyContent: 'center', alignItems: 'center' }]}>
        <Text style={{ fontFamily: 'Poppins-Medium' }}>College not found</Text>
        <TouchableOpacity onPress={() => navigation.goBack()} style={{ marginTop: 10 }}>
          <Text style={{ color: '#2D6EFF' }}>Go Back</Text>
        </TouchableOpacity>
      </View>
    );
  }

  const campusLocation = college.city && college.state ? `${college.city}, ${college.state}` : college.address || "N/A";

  const items = [
    { id: 1, title: "Location", subtitle: campusLocation, icon: "location-outline" },
    { id: 2, title: "Established", subtitle: college.established_year || "N/A", icon: "calendar-outline" },
    { id: 3, title: "Affiliation", subtitle: college.affiliation || "N/A", icon: "business-outline" },
    { id: 4, title: "NIRF Rank", subtitle: college.nirf_ranking ? college.nirf_ranking.toString() : "N/A", icon: "medal-outline" },
    { id: 5, title: "Students", subtitle: `${college.total_students || 0}+`, icon: "people-circle-outline" },
    { id: 6, title: "Faculty", subtitle: `${college.total_faculty || 0}+`, icon: "people-outline" },
    { id: 8, title: "Campus", subtitle: college.campus_size || "N/A", icon: "map-outline" },
    { id: 9, title: "Website", subtitle: "Visit", icon: "globe-outline", link: college.website },
  ];

  const rows = [];
  for (let i = 0; i < items.length; i += 2) {
    rows.push([items[i], items[i + 1]]);
  }

  const renderBankDetails = () => {
    const qrPath = bankDetails.qr_code_path || bankDetails.qr_code || bankDetails.qr_path;
    let qrUrl = null;
    if (qrPath) {
      const cleanPath = qrPath.startsWith('/') ? qrPath.substring(1) : qrPath;
      qrUrl = qrPath.startsWith('http') ? qrPath : `${BASE_IMAGE_URL}${cleanPath}`;
    }

    return (
      <View style={styles.bankCard}>
        <View style={styles.bankHeader}>
          <View style={styles.bankHeaderIcon}>
            <Icon name="business" size={24} color="#fff" />
          </View>
          <View style={{ marginLeft: 12 }}>
            <Text style={styles.bankTitle}>Fee Payment Details</Text>
            <Text style={styles.bankSubtitleHeader}>Official College Account</Text>
          </View>
        </View>

        <View style={styles.bankInfoContainer}>
          <View style={styles.infoRow}>
            <View style={styles.infoCol}>
              <Text style={styles.infoLabel}>Account Holder</Text>
              <Text style={styles.infoValue} numberOfLines={1}>{bankDetails.account_holder_name || 'N/A'}</Text>
            </View>
            <View style={styles.infoCol}>
              <Text style={styles.infoLabel}>Bank Name</Text>
              <Text style={styles.infoValue} numberOfLines={1}>{bankDetails.bank_name || 'N/A'}</Text>
            </View>
          </View>

          <View style={styles.infoRow}>
            <View style={[styles.infoCol, { flex: 1.5 }]}>
              <Text style={styles.infoLabel}>Account Number</Text>
              <Text style={[styles.infoValue, { letterSpacing: 1 }]}>{bankDetails.account_number || 'N/A'}</Text>
            </View>
            <View style={styles.infoCol}>
              <Text style={styles.infoLabel}>IFSC Code</Text>
              <Text style={[styles.infoValue, { color: '#2D6EFF' }]}>{bankDetails.ifsc_code || 'N/A'}</Text>
            </View>
          </View>

          {(bankDetails.upi_id || bankDetails.upi) && (
            <View style={styles.upiBox}>
              <Icon name="phone-portrait-outline" size={16} color="#666" />
              <Text style={styles.upiLabel}>UPI ID:</Text>
              <Text style={styles.upiValue}>{bankDetails.upi_id || bankDetails.upi}</Text>
            </View>
          )}
        </View>

        <View style={styles.qrSection}>
          <View style={styles.qrDivider} />
          <Text style={styles.qrSectionTitle}>Scan to Securely Pay</Text>
          <View style={styles.qrExternalFrame}>
            <View style={styles.qrInternalFrame}>
              {qrUrl ? (
                <Image
                  source={{ uri: qrUrl }}
                  style={styles.qrImageLarge}
                  key={qrUrl} // Force reload if path changes
                />
              ) : (
                <View style={[styles.qrImageLarge, { justifyContent: 'center', alignItems: 'center', backgroundColor: '#f0f0f0' }]}>
                  <Icon name="qr-code-outline" size={40} color="#ccc" />
                  <Text style={{ fontSize: 10, color: '#999', marginTop: 5 }}>QR Not Available</Text>
                </View>
              )}
            </View>
          </View>
          <View style={styles.qrBadge}>
            <Icon name="shield-checkmark" size={12} color="#0D652D" />
            <Text style={styles.qrBadgeText}>Verified Payment Method</Text>
          </View>
        </View>

        <View style={styles.bankFooter}>
          <Icon name="location-outline" size={14} color="#666" />
          <Text style={styles.branchText} numberOfLines={1}>{bankDetails.branch_name || 'N/A Branch'}</Text>
        </View>
      </View>
    );
  };

  const bannerImage = college.cover_image || college.logo;

  return (
    <SafeAreaView style={styles.container}>
      <StatusBar backgroundColor="#fff" barStyle="dark-content" />

      {/* TOP IMAGE */}
      <View style={styles.imageOverlayContainer}>
        <Image
          source={
            bannerImage
              ? { uri: getImageUrl(bannerImage) }
              : require("../assets/Image/Educational.png")
          }
          style={styles.imageStyle}
          resizeMode="cover"
        />
        <View style={styles.overlayGradient} />
      </View>

      {/* HEADER */}
      <View style={styles.header}>
        <TouchableOpacity style={styles.backBtn} onPress={() => navigation.goBack()}>
          <Icon name="arrow-back" size={24} color="#fff" />
        </TouchableOpacity>
        <Text style={styles.headerTitle} numberOfLines={2}>{college.name}</Text>
      </View>

      {/* LOGO */}
      <View style={styles.logoContainer}>
        <Image
          source={
            getImageUrl(college.logo)
              ? { uri: getImageUrl(college.logo) }
              : require("../assets/Image/logo.png")
          }
          style={styles.logoImg}
        />
      </View>

      {/* INFO BOX */}
      <ScrollView contentContainerStyle={styles.scroll} showsVerticalScrollIndicator={false}>

        <Text style={styles.uniName}>{college.name}</Text>

        <View style={styles.badgeRow}>
          {college.rating && (
            <View style={[styles.badge, { backgroundColor: '#FFF9E6' }]}>
              <Icon name="star" size={14} color="#FFD700" />
              <Text style={[styles.badgeText, { color: '#B8860B' }]}>{college.rating}</Text>
            </View>
          )}
          {college.accreditation && (
            <View style={[styles.badge, { backgroundColor: '#E6F4EA' }]}>
              <Icon name="checkmark-circle" size={14} color="#34A853" />
              <Text style={[styles.badgeText, { color: '#0D652D' }]}>{college.accreditation}</Text>
            </View>
          )}
          {college.type && (
            <View style={[styles.badge, { backgroundColor: '#E8F0FE' }]}>
              <Icon name="school" size={14} color="#4285F4" />
              <Text style={[styles.badgeText, { color: '#174EA6' }]}>{college.type.toUpperCase()}</Text>
            </View>
          )}
        </View>

        <Text style={[styles.sectionTitle, { marginTop: 10 }]}>About</Text>
        <Text style={styles.uniDesc}>{stripHtmlTags(college.description)}</Text>

        {/* GENERAL INFO GRID */}
        <View style={styles.card}>
          <Text style={styles.cardHeader}>Academic Overview</Text>
          {rows.map((pair, idx) => (
            <View
              key={idx}
              style={[styles.row, idx !== rows.length - 1 && styles.rowDivider]}
            >
              <TouchableOpacity
                style={styles.cell}
                activeOpacity={0.7}
                onPress={() => pair[0].link && Linking.openURL(pair[0].link)}
              >
                <View style={styles.iconWrap}>
                  <Icon name={pair[0].icon} size={20} color="#2D6EFF" />
                </View>
                <View style={styles.textWrap}>
                  <Text style={styles.title}>{pair[0].title}</Text>
                  <Text style={styles.subtitle} numberOfLines={1}>{pair[0].subtitle}</Text>
                </View>
              </TouchableOpacity>

              {pair[1] ? (
                <TouchableOpacity
                  style={styles.cell}
                  activeOpacity={0.7}
                  onPress={() => pair[1].link && Linking.openURL(pair[1].link)}
                >
                  <View style={styles.iconWrap}>
                    <Icon name={pair[1].icon} size={20} color="#2D6EFF" />
                  </View>
                  <View style={styles.textWrap}>
                    <Text style={styles.title}>{pair[1].title}</Text>
                    <Text style={styles.subtitle} numberOfLines={1}>{pair[1].subtitle}</Text>
                  </View>
                </TouchableOpacity>
              ) : (
                <View style={[styles.cell, { opacity: 0 }]} />
              )}
            </View>
          ))}
        </View>

        {/* PLACEMENT SECTION */}
        <View style={styles.placementCard}>
          <View style={styles.placementHeader}>
            <Icon name="trending-up" size={22} color="#fff" />
            <Text style={styles.placementTitle}>Placement Highlights</Text>
          </View>
          <View style={styles.placementBody}>
            <View style={styles.pkgBox}>
              <Text style={styles.pkgLabel}>Average Package</Text>
              <Text style={styles.pkgValue}>{formatCurrency(college.average_package)}</Text>
            </View>
            <View style={styles.verticalDivider} />
            <View style={styles.pkgBox}>
              <Text style={styles.pkgLabel}>Highest Package</Text>
              <Text style={styles.pkgValue}>{formatCurrency(college.highest_package)}</Text>
            </View>
          </View>
          {college.top_recruiters && college.top_recruiters.length > 0 && (
            <View style={styles.recruitersSection}>
              <Text style={styles.recruitersLabel}>Top Recruiters:</Text>
              <View style={styles.tagContainer}>
                {college.top_recruiters.slice(0, 5).map((r, i) => (
                  <View key={i} style={styles.recruitTag}>
                    <Text style={styles.tagText}>{r}</Text>
                  </View>
                ))}
              </View>
            </View>
          )}
        </View>

        {/* FACILITIES SECTION */}
        {college.facilities && college.facilities.length > 0 && (
          <View style={styles.wideCard}>
            <Text style={styles.cardHeader}>Key Facilities</Text>
            <View style={styles.facilitiesGrid}>
              {college.facilities.map((f, i) => (
                <View key={i} style={styles.facilityItem}>
                  <Icon name="checkmark-done" size={16} color="#4CAF50" />
                  <Text style={styles.facilityText}>{f}</Text>
                </View>
              ))}
            </View>
          </View>
        )}

        {/* BANK DETAILS SECTION */}
        {bankDetails && renderBankDetails()}

        <View style={{ height: 40 }} />
      </ScrollView>
    </SafeAreaView>
  );
};

export default RML;

const styles = StyleSheet.create({
  container: { flex: 1, backgroundColor: "#F8FAFF" }, // Lighter bg for premium feel

  imageOverlayContainer: {
    width: "100%",
    height: hp("28%"),
    position: 'relative'
  },
  imageStyle: {
    width: "100%",
    height: "100%",
  },
  overlayGradient: {
    position: 'absolute',
    bottom: 0,
    width: '100%',
    height: '50%',
    backgroundColor: 'rgba(0,0,0,0.3)',
  },

  header: {
    position: "absolute",
    top: hp("4%"),
    left: wp("4%"),
    right: wp("4%"),
    flexDirection: "row",
    alignItems: "center",
    zIndex: 10
  },

  backBtn: {
    width: 40,
    height: 40,
    borderRadius: 20,
    backgroundColor: "rgba(45, 110, 255, 0.9)",
    justifyContent: "center",
    alignItems: "center",
  },

  headerTitle: {
    fontSize: RFPercentage(2.3),
    fontFamily: 'Poppins-SemiBold',
    color: "#fff",
    marginLeft: 15,
    flex: 1,
    textShadowColor: 'rgba(0, 0, 0, 0.5)',
    textShadowOffset: { width: 0, height: 1 },
    textShadowRadius: 5
  },

  logoContainer: {
    alignItems: "center",
    marginTop: -hp("7%"),
    zIndex: 20
  },

  logoImg: {
    width: wp("26%"),
    height: wp("26%"),
    resizeMode: "contain",
    borderRadius: wp("13%"),
    backgroundColor: "#fff",
    borderWidth: 4,
    borderColor: "#F8FAFF",
    padding: 5,
    elevation: 10,
    shadowColor: "#000",
    shadowOpacity: 0.15,
    shadowRadius: 10,
    shadowOffset: { width: 0, height: 5 },
  },

  scroll: { paddingVertical: hp("2%"), alignItems: "center", paddingBottom: 50 },

  uniName: {
    fontSize: RFPercentage(2.6),
    fontFamily: 'Poppins-Bold',
    color: '#1A1D1E',
    marginTop: 15,
    textAlign: 'center',
    paddingHorizontal: 20
  },

  badgeRow: {
    flexDirection: 'row',
    marginTop: 10,
    gap: 8,
    flexWrap: 'wrap',
    justifyContent: 'center'
  },
  badge: {
    flexDirection: 'row',
    alignItems: 'center',
    paddingHorizontal: 12,
    paddingVertical: 5,
    borderRadius: 20,
    gap: 5
  },
  badgeText: {
    fontSize: RFPercentage(1.5),
    fontFamily: 'Poppins-SemiBold',
  },

  sectionTitle: {
    fontSize: RFPercentage(2),
    fontFamily: 'Poppins-SemiBold',
    color: '#000',
    alignSelf: 'flex-start',
    marginLeft: wp('4%'),
    marginBottom: 5
  },

  uniDesc: {
    fontSize: RFPercentage(1.7),
    color: '#555',
    textAlign: 'left',
    paddingHorizontal: wp('4%'),
    marginBottom: 20,
    fontFamily: 'Poppins-Regular',
    lineHeight: 22
  },

  card: {
    width: wp("92%"),
    borderRadius: 15,
    backgroundColor: "#fff",
    paddingTop: 15,
    overflow: "hidden",
    elevation: 4,
    shadowColor: "#000",
    shadowOpacity: 0.05,
    shadowRadius: 10,
    shadowOffset: { width: 0, height: 4 },
    marginBottom: 20
  },
  cardHeader: {
    fontSize: 16,
    fontFamily: 'Poppins-SemiBold',
    color: '#000',
    paddingHorizontal: 20,
    marginBottom: 10
  },

  row: {
    flexDirection: "row",
    paddingVertical: 15,
    paddingHorizontal: 20,
    alignItems: "center",
    justifyContent: "space-between",
  },
  rowDivider: {
    borderBottomWidth: 1,
    borderBottomColor: "#F0F2F5",
  },
  cell: {
    width: "48%",
    flexDirection: "row",
    alignItems: "center",
  },
  iconWrap: {
    width: 36,
    height: 36,
    borderRadius: 10,
    backgroundColor: "#EFF6FF",
    justifyContent: "center",
    alignItems: "center",
    marginRight: 10,
  },
  title: {
    fontSize: 12,
    color: "#667085",
    fontFamily: "Poppins-Medium",
  },
  subtitle: {
    fontSize: 13,
    color: "#1A1D1E",
    fontFamily: "Poppins-SemiBold",
    marginTop: 2
  },

  placementCard: {
    width: wp('92%'),
    backgroundColor: '#2D6EFF',
    borderRadius: 15,
    padding: 20,
    marginBottom: 20,
    elevation: 5,
  },
  placementHeader: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: 10,
    marginBottom: 15
  },
  placementTitle: {
    color: '#fff',
    fontSize: 18,
    fontFamily: 'Poppins-SemiBold'
  },
  placementBody: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    backgroundColor: 'rgba(255,255,255,0.1)',
    borderRadius: 12,
    padding: 15
  },
  pkgBox: {
    flex: 1,
    alignItems: 'center'
  },
  pkgLabel: {
    color: 'rgba(255,255,255,0.8)',
    fontSize: 12,
    fontFamily: 'Poppins-Regular'
  },
  pkgValue: {
    color: '#fff',
    fontSize: 17,
    fontFamily: 'Poppins-Bold',
    marginTop: 4
  },
  verticalDivider: {
    width: 1,
    backgroundColor: 'rgba(255,255,255,0.2)'
  },
  recruitersSection: {
    marginTop: 15
  },
  recruitersLabel: {
    color: '#fff',
    fontSize: 13,
    fontFamily: 'Poppins-Medium',
    marginBottom: 8
  },
  tagContainer: {
    flexDirection: 'row',
    flexWrap: 'wrap',
    gap: 8
  },
  recruitTag: {
    backgroundColor: 'rgba(255,255,255,0.2)',
    paddingHorizontal: 12,
    paddingVertical: 4,
    borderRadius: 8
  },
  tagText: {
    color: '#fff',
    fontSize: 11,
    fontFamily: 'Poppins-Medium'
  },

  wideCard: {
    width: wp('92%'),
    backgroundColor: '#fff',
    borderRadius: 15,
    padding: 20,
    marginBottom: 20,
    elevation: 4
  },
  facilitiesGrid: {
    flexDirection: 'row',
    flexWrap: 'wrap',
    marginTop: 5
  },
  facilityItem: {
    flexDirection: 'row',
    alignItems: 'center',
    width: '50%',
    paddingVertical: 8,
    gap: 8
  },
  facilityText: {
    fontSize: 13,
    color: '#444',
    fontFamily: 'Poppins-Medium'
  },

  bankCard: {
    width: wp('92%'),
    backgroundColor: '#FFF',
    borderRadius: 20,
    padding: 20,
    elevation: 8,
    shadowColor: '#2D6EFF',
    shadowOpacity: 0.12,
    shadowRadius: 15,
    shadowOffset: { width: 0, height: 8 },
    borderWidth: 1,
    borderColor: '#E0E7FF',
    marginBottom: 30
  },
  bankHeader: {
    flexDirection: 'row',
    alignItems: 'center',
    marginBottom: 20,
  },
  bankHeaderIcon: {
    width: 48,
    height: 48,
    borderRadius: 14,
    backgroundColor: '#2D6EFF',
    justifyContent: 'center',
    alignItems: 'center',
    elevation: 4
  },
  bankTitle: {
    fontSize: 18,
    fontFamily: 'Poppins-Bold',
    color: '#1A1D1E'
  },
  bankSubtitleHeader: {
    fontSize: 12,
    color: '#667085',
    fontFamily: 'Poppins-Medium',
    marginTop: -2
  },
  bankInfoContainer: {
    backgroundColor: '#F9FBFF',
    borderRadius: 15,
    padding: 15,
    gap: 15
  },
  infoRow: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    gap: 10
  },
  infoCol: {
    flex: 1
  },
  infoLabel: {
    fontSize: 10,
    color: '#667085',
    fontFamily: 'Poppins-Medium',
    textTransform: 'uppercase',
    letterSpacing: 0.5
  },
  infoValue: {
    fontSize: 14,
    color: '#1A1D1E',
    fontFamily: 'Poppins-SemiBold',
    marginTop: 2
  },
  upiBox: {
    flexDirection: 'row',
    alignItems: 'center',
    backgroundColor: '#fff',
    padding: 10,
    borderRadius: 10,
    borderWidth: 1,
    borderColor: '#E0E7FF',
    marginTop: 5
  },
  upiLabel: {
    fontSize: 12,
    color: '#666',
    fontFamily: 'Poppins-Medium',
    marginLeft: 8
  },
  upiValue: {
    fontSize: 12,
    color: '#2D6EFF',
    fontFamily: 'Poppins-Bold',
    marginLeft: 5
  },
  qrSection: {
    alignItems: 'center',
    marginTop: 20
  },
  qrDivider: {
    width: '100%',
    height: 1,
    backgroundColor: '#F0F2F5',
    marginBottom: 20
  },
  qrSectionTitle: {
    fontSize: 15,
    fontFamily: 'Poppins-SemiBold',
    color: '#1A1D1E',
    marginBottom: 15
  },
  qrExternalFrame: {
    padding: 12,
    backgroundColor: '#fff',
    borderRadius: 20,
    elevation: 5,
    shadowColor: '#000',
    shadowOpacity: 0.1,
    shadowRadius: 10,
    borderWidth: 1,
    borderColor: '#F0F2F5'
  },
  qrInternalFrame: {
    padding: 8,
    borderWidth: 2,
    borderColor: '#2D6EFF',
    borderStyle: 'dashed',
    borderRadius: 12
  },
  qrImageLarge: {
    width: wp('35%'),
    height: wp('35%'),
    resizeMode: 'contain',
  },
  qrBadge: {
    flexDirection: 'row',
    alignItems: 'center',
    backgroundColor: '#E6F4EA',
    paddingHorizontal: 12,
    paddingVertical: 5,
    borderRadius: 20,
    marginTop: 15,
    gap: 5
  },
  qrBadgeText: {
    fontSize: 11,
    color: '#0D652D',
    fontFamily: 'Poppins-SemiBold'
  },
  bankFooter: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'center',
    marginTop: 20,
    gap: 5
  },
  branchText: {
    fontSize: 11,
    color: '#667085',
    fontFamily: 'Poppins-Medium',
    textAlign: 'center'
  }
});

