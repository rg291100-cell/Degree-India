import {
  View,
  Text,
  StyleSheet,
  TouchableOpacity,
  TextInput,
  StatusBar,
  FlatList,
  Image,
  ActivityIndicator
} from "react-native";
import React, { useEffect, useState } from "react";
import Icon from "react-native-vector-icons/Ionicons";
import { useNavigation } from "@react-navigation/native";
import { SafeAreaView } from 'react-native-safe-area-context';
import {
  widthPercentageToDP as wp,
  heightPercentageToDP as hp,
} from "react-native-responsive-screen";
import { RFPercentage } from "react-native-responsive-fontsize";
import { getApi, BASE_IMAGE_URL } from '../config/api';

const Educationalpartners = () => {
  const navigation = useNavigation();
  const [partners, setPartners] = useState([]);
  const [loading, setLoading] = useState(false);
  const [search, setSearch] = useState('');

  const getUniversities = async () => {
    try {
      setLoading(true);
      // ✅ FIX: Use correct endpoint /get-colleges (backend returns 'colleges' with pagination)
      const res = await getApi('/get-colleges', false);
      console.log("Colleges API Response:", JSON.stringify(res));
      // Backend returns: { colleges: { data: [...], current_page, ... } }
      setPartners(res?.colleges?.data || res?.data || []);
    } catch (error) {
      console.log("Error fetching colleges:", error);
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    getUniversities();
  }, []);

  const handlePress = (item) => {
    navigation.navigate('RML', { data: item });
  };

  const filteredPartners = partners.filter(item =>
    item?.name?.toLowerCase().includes(search.toLowerCase())
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
        <Text style={styles.headerTitle}>Educational Partners</Text>
        <View />
      </View>

      {/* SEARCH BAR */}
      <View style={styles.searchContainer}>
        <Icon name="search-outline" size={22} color="#2D6EFF" />
        <TextInput
          placeholder="Search Colleges"
          placeholderTextColor="#555"
          style={styles.input}
          value={search}
          onChangeText={setSearch}
        />
        <TouchableOpacity>
          <Icon name="filter" size={22} color="#2D6EFF" />
        </TouchableOpacity>
      </View>

      {/* LIST */}
      {loading ? (
        <View style={styles.loader}>
          <ActivityIndicator size="large" color="#2D6EFF" />
          <Text>Loading universities...</Text>
        </View>
      ) : (
        <FlatList
          data={filteredPartners}
          numColumns={2}
          keyExtractor={(item) => item.id?.toString() || Math.random().toString()}
          columnWrapperStyle={{ justifyContent: "space-between" }}
          contentContainerStyle={{ padding: wp("4%") }}
          ListEmptyComponent={
            <Text style={{ textAlign: 'center', marginTop: 20 }}>No universities found.</Text>
          }
          renderItem={({ item }) => (
            <TouchableOpacity onPress={() => handlePress(item)} style={styles.card}>
              {/* University Image */}
              <Image
                source={
                  item.cover_image || item.logo || item.image
                    ? {
                      uri: (item.cover_image || item.logo || item.image).startsWith('http')
                        ? (item.cover_image || item.logo || item.image)
                        : `${BASE_IMAGE_URL}${item.cover_image || item.logo || item.image}`
                    }
                    : require("../assets/Image/Educational.png")
                }
                style={styles.image}
                resizeMode="cover"
              />

              {/* White Circle or Logo if available */}
              <View style={styles.whiteCircle}>
                {item.logo ? <Image source={{ uri: item.logo.startsWith('http') ? item.logo : `${BASE_IMAGE_URL}${item.logo}` }} style={{ width: '100%', height: '100%', borderRadius: 50 }} /> : null}
              </View>

              {/* University Name */}
              <Text style={styles.uniName} numberOfLines={3}>{item.name || item.college_name}</Text>

              {item.location && <Text style={styles.location}>{item.location}</Text>}

            </TouchableOpacity>
          )}
        />
      )}
    </SafeAreaView>
  );
};

export default Educationalpartners;

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
  },
  input: {
    flex: 1,
    fontSize: RFPercentage(2),
    marginHorizontal: wp("2%"),
    color: "#000",
    fontFamily: 'Poppins-Regular',
  },
  card: {
    width: wp("44%"),
    marginBottom: hp("3%"),
    alignItems: "center",
    backgroundColor: '#fff',
    borderRadius: wp('3%'),
    elevation: 3,
    paddingBottom: 10,
    shadowColor: "#000",
    shadowOffset: { width: 0, height: 2 },
    shadowOpacity: 0.1,
    shadowRadius: 4,
  },
  image: {
    width: wp("44%"),
    height: hp("15%"),
    borderTopLeftRadius: wp("3%"),
    borderTopRightRadius: wp("3%"),
  },
  whiteCircle: {
    width: wp("12%"),
    height: wp("12%"),
    borderRadius: wp("6%"),
    backgroundColor: "#FFF",
    position: "absolute",
    top: hp("1%"),
    right: wp("2%"),
    justifyContent: 'center',
    alignItems: 'center',
    elevation: 2,
    overflow: 'hidden'
  },
  uniName: {
    marginTop: hp("1%"),
    fontSize: RFPercentage(1.8),
    fontFamily: 'Poppins-SemiBold',
    color: "#000",
    textAlign: 'center',
    paddingHorizontal: 5
  },
  location: {
    fontSize: RFPercentage(1.4),
    fontFamily: 'Poppins-Regular',
    color: "#666",
    textAlign: 'center'
  },
  loader: {
    marginTop: 50,
    alignItems: 'center'
  }
});
