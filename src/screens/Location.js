import React, { useEffect, useState } from 'react';
import {
  View,
  Text,
  StyleSheet,
  TextInput,
  TouchableOpacity,
  Alert,
  ActivityIndicator,
  Image,
} from 'react-native';
import { useNavigation, useRoute } from '@react-navigation/native';
import axios from 'axios';
import { BASE_URL, getApi, postApi } from '../config/api';
import AsyncStorage from '@react-native-async-storage/async-storage';
import { SafeAreaView } from 'react-native-safe-area-context';

const Location = () => {
  const navigation = useNavigation();
  const route = useRoute();
  const { name, email, mobile } = route.params;

  const [bannerLoading, setBannerLoading] = useState(true);
  const [apiLoading, setApiLoading] = useState(false);

  const [locationText, setLocationText] = useState('');
  const [location, setLocation] = useState('');
  const [showOtp, setShowOtp] = useState(false);
  const [otp, setOtp] = useState('');

  // 🔹 Fetch banner ONLY
  useEffect(() => {
    const fetchRegisterContent = async () => {
      try {
        const response = await getApi('/register-content', false);
        setLocationText(response?.data?.[0]?.location_image || '');
      } catch (error) {
        Alert.alert('Error', 'Failed to load banner');
      } finally {
        setBannerLoading(false);
      }
    };

    fetchRegisterContent();
  }, []);

  // 🔹 Register
  const handleRegister = async () => {
    if (!location.trim()) {
      Alert.alert('Validation', 'Please enter your location');
      return;
    }

    setApiLoading(true);
    try {
      const payload = { name, email, phone: mobile, location };
      console.log("Pay Load register ", payload);

      const data = await postApi('/auth/register', payload, false);
      console.log("registur Api Res", data);

      setShowOtp(true);
    } catch (error) {
      Alert.alert('Error', error.response?.data?.message || 'Something went wrong');
    } finally {
      setApiLoading(false);
    }
  };

  // 🔹 Verify OTP
  const handleVerifyOtp = async () => {
    if (!otp.trim()) {
      Alert.alert('Validation', 'Please enter OTP');
      return;
    }

    setApiLoading(true);
    try {
      const data = await postApi('/auth/verify-otp', { email, otp }, false);

      await AsyncStorage.setItem('AUTH_TOKEN', data.token);

      navigation.reset({
        index: 0,
        routes: [
          {
            name: 'TabNavigation',
            state: {
              routes: [{ name: 'Home' }],
            },
          },
        ],
      });
    } catch (error) {
      Alert.alert('Error', 'Invalid OTP');
    } finally {
      setApiLoading(false);
    }
  };

  return (
    <SafeAreaView style={styles.container}>
      {/* 🔹 BANNER */}
      <View style={styles.bannerWrapper}>
        {bannerLoading ? (
          <ActivityIndicator size="large" color="#2D6EFF" />
        ) : locationText ? (
          <Image
            source={{
              uri: `https://argosmob.uk/degree-india/storage/app/public/${locationText}`,
            }}
            style={styles.bannerImage}
            resizeMode="cover"
          />
        ) : null}
      </View>

      {/* 🔹 FORM */}
      {!showOtp ? (
        <>
          <Text style={styles.title}>Your Location</Text>

          <TextInput
            value={location}
            onChangeText={setLocation}
            placeholder="Enter your Location"
            style={styles.input}
          />

          <TouchableOpacity
            style={styles.nextBtn}
            onPress={handleRegister}
            disabled={apiLoading}
          >
            {apiLoading ? (
              <ActivityIndicator color="#fff" />
            ) : (
              <Text style={styles.btnText}>Register</Text>
            )}
          </TouchableOpacity>
        </>
      ) : (
        <>
          <Text style={styles.title}>Enter OTP</Text>

          <TextInput
            value={otp}
            onChangeText={t => setOtp(t.replace(/[^0-9]/g, ''))}
            placeholder="Enter OTP"
            keyboardType="number-pad"
            maxLength={6}
            style={styles.input}
          />

          <TouchableOpacity
            style={styles.nextBtn}
            onPress={handleVerifyOtp}
            disabled={apiLoading}
          >
            {apiLoading ? (
              <ActivityIndicator color="#fff" />
            ) : (
              <Text style={styles.btnText}>Verify OTP</Text>
            )}
          </TouchableOpacity>
        </>
      )}
    </SafeAreaView>
  );
};

export default Location;
const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#F6F8FC',
    // paddingHorizontal: 20,
  },

  bannerWrapper: {
    width: '100%',
    height: 250,
    backgroundColor: '#EAEAEA',
    justifyContent: 'center',
    alignItems: 'center',
    marginBottom: 20,
  },

  bannerImage: {
    width: '100%',
    height: '100%',
  },

  title: {
    fontSize: 18,
    fontWeight: '500',
    marginBottom: 8,
    fontFamily: 'Poppins-Regular',
    paddingHorizontal: 20,

  },

  input: {
    backgroundColor: '#FFFFFF',
    borderWidth: 1,
    borderColor: '#E1E4EA',
    paddingVertical: 14,
    paddingHorizontal: 16,
    borderRadius: 10,
    fontSize: 16,
    marginBottom: 18,
    fontFamily: 'Poppins-Regular',
    marginHorizontal: 20,

  },

  nextBtn: {
    backgroundColor: '#2D6EFF',
    paddingVertical: 15,
    borderRadius: 12,
    alignItems: 'center',
    marginHorizontal: 20,

  },

  btnText: {
    color: '#fff',
    fontSize: 16,
    fontWeight: '600',
    fontFamily: 'Poppins-SemiBold',
  },
});
