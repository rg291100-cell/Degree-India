import { View, Text, StatusBar, Image, TouchableOpacity, FlatList } from 'react-native';
import React from 'react';
import { StyleSheet } from 'react-native';
import Icon from "react-native-vector-icons/Ionicons";
import { useNavigation } from '@react-navigation/native';
import {
  widthPercentageToDP as wp,
  heightPercentageToDP as hp,
} from 'react-native-responsive-screen';
import { RFPercentage } from 'react-native-responsive-fontsize';
import { SafeAreaView } from 'react-native-safe-area-context';

const Animation = () => {
  const navigation = useNavigation();

  const data = [
    { id: 1, title: '3D Animation', bg: '#E4FFE5', price: 2340, joined: 245, discount: "25% Off", image: require('../assets/Image/3D.png') },
    { id: 2, title: '2D Animation', bg: '#FFE6F6', price: 1800, joined: 180, discount: "20% Off", image: require('../assets/Image/2D.png') },
    { id: 3, title: 'Visual Effects (VFX)', bg: '#E1F3FF', price: 3000, joined: 320, discount: "30% Off", image: require('../assets/Image/VFX.png') },
    { id: 4, title: 'Motion Graphics', bg: '#FFF2D9', price: 2200, joined: 210, discount: "15% Off", image: require('../assets/Image/Motion.png') },
    { id: 5, title: 'Stop Motion', bg: '#EDE5FF', price: 2750, joined: 290, discount: "18% Off", image: require('../assets/Image/Stop.png') }
  ];

  const handlePreess = (item) => {
    
    navigation.navigate('DAnimation',{data: item});
  }



  return (
    <SafeAreaView style={styles.container}>
      <StatusBar backgroundColor="#fff" barStyle="dark-content" />

      {/* ---- TOP IMAGE ---- */}
      <Image source={require("../assets/Image/Animation.png")} style={styles.imageStyle} />

      {/* ---- HEADER ---- */}
      <View style={styles.header}>
        <TouchableOpacity style={styles.backBtn} onPress={() => navigation.goBack()}>
          <Icon name="arrow-back" size={24} color="#fff" />
        </TouchableOpacity>
        <Text style={styles.headerTitle}>Animation</Text>
      </View>

      {/* ---- COURSE GRID ---- */}
      <FlatList
        data={data}
        numColumns={2}
        keyExtractor={(item) => item.id.toString()}
        showsVerticalScrollIndicator={false}
        columnWrapperStyle={{ justifyContent: "space-between", marginTop: hp("2%") }}
        contentContainerStyle={{ paddingHorizontal: wp("4%"), paddingBottom: hp("5%") }}
        renderItem={({ item }) => (
          <TouchableOpacity onPress={handlePreess} style={styles.card}>
            
            {/* Course Image */}
            <Image source={item.image} style={styles.courseImage} />

            {/* Price Tag */}
            <View style={styles.priceTag}>
              <Text style={styles.priceText}>₹ {item.price}</Text>
            </View>

            {/* Text info */}
            <Text style={styles.title}>{item.title}</Text>
            <Text style={styles.joinText}>{item.joined} Joined</Text>
            <Text style={styles.discount}>{item.discount}</Text>
          </TouchableOpacity>
        )}
      />
    </SafeAreaView>
  );
};

export default Animation;

const styles = StyleSheet.create({
  container: { flex: 1, backgroundColor: "#fff" },

  imageStyle: {
    width: wp("100%"),
    height: hp("30%"),
    resizeMode: "cover",
  },

  header: {
    position: "absolute",
    top: hp("5%"),
    left: wp("4%"),
    flexDirection: "row",
    alignItems: "center",
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
    fontWeight: "700",
    color: "#fff",
    marginLeft: wp("4%"),
  },

  card: {
    width: wp("44%"),
    marginBottom: hp("2.5%"),
  },

  courseImage: {
    width: wp("44%"),
    height: hp("18%"),
    borderRadius: wp("3%"),
  },

  priceTag: {
    position: "absolute",
    backgroundColor: "#fff",
    paddingVertical: hp("0.3%"),
    paddingHorizontal: wp("2%"),
    borderRadius: 10,
    top: hp("1%"),
    right: wp("2%"),
    elevation: 5,
  },

  priceText: {
    fontWeight: "700",
    fontSize: RFPercentage(1.8),
  },

  title: {
    marginTop: hp("1%"),
    fontSize: RFPercentage(2),
    fontWeight: "700",
  },

  joinText: {
    color: "#666",
    fontSize: RFPercentage(1.7),
  },

  discount: {
    color: "red",
    fontSize: RFPercentage(1.8),
    fontWeight: "600",
  },
});
