import {
  View,
  Text,
  StatusBar,
  TouchableOpacity,
  StyleSheet,
  Image,
  ScrollView,
  Linking
} from "react-native";

import React from "react";
import Icon from "react-native-vector-icons/Ionicons";
import { useNavigation, useRoute } from "@react-navigation/native";
import { SafeAreaView } from 'react-native-safe-area-context';
import {
  widthPercentageToDP as wp,
  heightPercentageToDP as hp,
} from "react-native-responsive-screen";
import { RFPercentage } from "react-native-responsive-fontsize";
import { BASE_IMAGE_URL } from '../config/api';

const RML = () => {
  const navigation = useNavigation();
  const route = useRoute();
  const { data } = route.params || {};

  // Mapping dynamic data or fallback
  const university = data || {
    name: "RML College",
    location: "Unknown",
    established: "1996",
    affiliation: "RML",
    image: null,
    logo: null
  };

  const getImageUrl = (path) => {
    if (!path) return null;
    return path.startsWith('http') ? path : `${BASE_IMAGE_URL}${path}`;
  };

  // ✅ FIX: Strip HTML tags from description
  const stripHtmlTags = (html) => {
    if (!html) return '';
    return html.replace(/<[^>]*>/g, '').replace(/&nbsp;/g, ' ').trim();
  };

  const items = [
    { id: 1, title: "Location", subtitle: university.location || "N/A", icon: "location-outline" },
    { id: 2, title: "EST", subtitle: university.established || "N/A", icon: "calendar-outline" },
    { id: 3, title: "Affiliation", subtitle: university.affiliation || "N/A", icon: "business-outline" },
    { id: 4, title: "Faculties", subtitle: university.faculties || "N/A", icon: "people-outline" },
    { id: 5, title: "Students Strength", subtitle: university.students_strength || "N/A", icon: "people-circle-outline" },
    { id: 6, title: "Hostel facilities", subtitle: university.hostel ? "Yes" : "No", icon: "home-outline" },
    { id: 7, title: "Transport Facilities", subtitle: university.transport ? "Yes" : "No", icon: "bus-outline" },
    { id: 9, title: "Website", subtitle: "Visit", icon: "globe-outline", link: university.website_link },
    { id: 15, title: "Courses Offer", subtitle: "View", icon: "book-outline" },
  ];

  // Create rows (two items per row)
  const rows = [];
  for (let i = 0; i < items.length; i += 2) {
    rows.push([items[i], items[i + 1]]);
  }

  // ✅ FIX: Use cover_image or logo for banner
  const bannerImage = university.cover_image || university.logo || university.image;

  return (
    <SafeAreaView style={styles.container}>
      <StatusBar backgroundColor="#fff" barStyle="dark-content" />

      {/* TOP IMAGE */}
      <Image
        source={
          bannerImage
            ? { uri: bannerImage.startsWith('http') ? bannerImage : `${BASE_IMAGE_URL}${bannerImage}` }
            : require("../assets/Image/Educational.png")
        }
        style={styles.imageStyle}
        resizeMode="cover"
      />

      {/* HEADER */}
      <View style={styles.header}>
        <TouchableOpacity style={styles.backBtn} onPress={() => navigation.goBack()}>
          <Icon name="arrow-back" size={24} color="#fff" />
        </TouchableOpacity>
        {/* ✅ FIX: Allow 2 lines for long names */}
        <Text style={styles.headerTitle} numberOfLines={2}>{university.name}</Text>
      </View>

      {/* LOGO */}
      <View style={styles.logoContainer}>
        <Image
          source={
            getImageUrl(university.logo)
              ? { uri: getImageUrl(university.logo) }
              : require("../assets/Image/logo.png")
          }
          style={styles.logoImg}
        />
      </View>

      {/* INFO BOX */}
      <ScrollView contentContainerStyle={styles.scroll} showsVerticalScrollIndicator={false}>

        <Text style={styles.uniName}>{university.name}</Text>
        <Text style={styles.uniDesc}>{stripHtmlTags(university.description)}</Text>

        <View style={styles.card}>
          {rows.map((pair, idx) => (
            <View
              key={idx}
              style={[styles.row, idx !== rows.length - 1 && styles.rowDivider]}
            >
              {/* LEFT CELL */}
              <TouchableOpacity
                style={styles.cell}
                activeOpacity={0.7}
                onPress={() => {
                  if (pair[0].link) Linking.openURL(pair[0].link);
                }}
              >
                <View style={styles.iconWrap}>
                  <Icon name={pair[0].icon} size={20} color="#222" />
                </View>
                <View style={styles.textWrap}>
                  <Text style={styles.title}>{pair[0].title}</Text>
                  <Text style={styles.subtitle}>{pair[0].subtitle}</Text>
                </View>
              </TouchableOpacity>

              {/* RIGHT CELL */}
              {pair[1] ? (
                <TouchableOpacity style={styles.cell} activeOpacity={0.7}>
                  <View style={styles.iconWrap}>
                    <Icon name={pair[1].icon} size={20} color="#222" />
                  </View>
                  <View style={styles.textWrap}>
                    <Text style={styles.title}>{pair[1].title}</Text>
                    <Text style={styles.subtitle}>{pair[1].subtitle}</Text>
                  </View>
                </TouchableOpacity>
              ) : (
                <View style={[styles.cell, { opacity: 0 }]} />
              )}
            </View>
          ))}
        </View>
      </ScrollView>
    </SafeAreaView>
  );
};

export default RML;

const styles = StyleSheet.create({
  container: { flex: 1, backgroundColor: "#fff" },

  imageStyle: {
    width: wp("100%"),
    height: hp("28%"),
    resizeMode: "cover",
  },

  header: {
    position: "absolute",
    top: hp("4%"),
    left: wp("4%"),
    right: wp("4%"),
    flexDirection: "row",
    alignItems: "center",
  },

  backBtn: {
    width: wp("10%"),
    height: wp("10%"),
    borderRadius: wp("5%"),
    backgroundColor: "#2D6EFF",
    justifyContent: "center",
    alignItems: "center",
  },

  headerTitle: {
    fontSize: RFPercentage(2.5),
    fontWeight: "700",
    color: "#fff",
    marginLeft: wp("4%"),
    flex: 1,
    textShadowColor: 'rgba(0, 0, 0, 0.75)',
    textShadowOffset: { width: -1, height: 1 },
    textShadowRadius: 10
  },

  logoContainer: {
    alignItems: "center",
    marginTop: hp("2%"),
  },

  logoImg: {
    width: wp("28%"),
    height: wp("28%"),
    resizeMode: "contain",
    borderRadius: wp("14%"),
    backgroundColor: "#fff",
    borderWidth: 1,
    borderColor: "#ccc",
    padding: 10,
  },

  scroll: { paddingVertical: hp("2%"), alignItems: "center", paddingBottom: 50 },

  uniName: {
    fontSize: RFPercentage(2.5),
    fontWeight: 'bold',
    color: '#000',
    marginBottom: 10,
    marginTop: 10,
    textAlign: 'center'
  },
  uniDesc: {
    fontSize: RFPercentage(1.8),
    color: '#555',
    textAlign: 'center',
    paddingHorizontal: 20,
    marginBottom: 20,
  },

  card: {
    width: wp("92%"),
    borderRadius: wp("3%"),
    borderWidth: 1,
    borderColor: "#ddd",
    backgroundColor: "#fff",
    overflow: "hidden",
    elevation: 3,
    shadowColor: "#000",
    shadowOpacity: 0.08,
    shadowRadius: 4,
    shadowOffset: { width: 0, height: 2 },
  },

  row: {
    flexDirection: "row",
    paddingVertical: hp("2.2%"),
    paddingHorizontal: wp("4%"),
    alignItems: "center",
    justifyContent: "space-between",
  },

  rowDivider: {
    borderBottomWidth: 1,
    borderBottomColor: "#eee",
  },

  cell: {
    width: "48%",
    flexDirection: "row",
    alignItems: "center",
  },

  iconWrap: {
    width: wp("9%"),
    height: wp("9%"),
    borderRadius: wp("4.5%"),
    borderWidth: 1,
    borderColor: "#eee",
    justifyContent: "center",
    alignItems: "center",
    marginRight: wp("3%"),
  },

  textWrap: {
    flex: 1,
  },

  title: {
    fontSize: RFPercentage(1.9),
    color: "#111",
    fontWeight: "600",
  },

  subtitle: {
    fontSize: RFPercentage(1.5),
    color: "#666",
    marginTop: hp("0.4%"),
  },
});
