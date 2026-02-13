import React, { useState } from 'react';
import {
  View,
  Text,
  StyleSheet,
  TextInput,
  TouchableOpacity,
  Alert,
  ActivityIndicator,
} from 'react-native';
import { useNavigation } from '@react-navigation/native';
import axios from 'axios';
import { BASE_URL, postApi } from '../config/api';
import { SafeAreaView } from 'react-native-safe-area-context';
import AsyncStorage from '@react-native-async-storage/async-storage';

const Login = () => {
  const navigation = useNavigation();

  const [email, setEmail] = useState('');
  const [otp, setOtp] = useState('');
  const [otpSent, setOtpSent] = useState(false);
  const [loading, setLoading] = useState(false);

  // 📩 Send OTP API call
  const handleSendOtp = async () => {
    if (!email.trim()) {
      Alert.alert('Error', 'Please enter email');
      return;
    }

    const payload = { email: email.trim() }; // ✅ Correct payload

    setLoading(true);
    try {
      console.log('Sending payload:', payload);

      // Use centralized postApi
      await postApi('/auth/login', payload, false);

      setOtpSent(true);
      Alert.alert('Success', 'OTP sent to your email');
    } catch (error) {
      console.log('=== ERROR DEBUG START ===');
      console.log('Full error:', error);

      if (error.response) {
        console.log('Response status:', error.response.status);
        console.log(
          'Response data:',
          JSON.stringify(error.response.data, null, 2),
        );
        Alert.alert("Error", "The selected email is invalid.");
      }

      console.log('=== ERROR DEBUG END ===');

      Alert.alert(
        'Error',
        error.response?.data?.message ||
        'Something went wrong. Check your input or network.',
      );
    } finally {
      setLoading(false);
    }
  };

  // ✅ Verify OTP
  const handleVerifyOtp = async () => {
    if (!otp.trim()) {
      Alert.alert('Validation', 'Please enter OTP');
      return;
    }

    setLoading(true);
    try {
      const payload = {
        email: email,
        otp: otp,
      };

      // Use centralized postApi
      const data = await postApi('/auth/verify-otp', payload, false);

      Alert.alert('Success', 'OTP verified successfully');
      const token = data.token;
      await AsyncStorage.setItem('AUTH_TOKEN', token);

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
      Alert.alert('Error', error.response?.data?.message || 'Invalid OTP');
    } finally {
      setLoading(false);
    }
  };

  return (
    <SafeAreaView style={styles.mainView}>
      <Text style={styles.title}>Login</Text>

      {/* Email Input */}
      <TextInput
        value={email}
        onChangeText={setEmail}
        placeholder="Enter Email"
        keyboardType="email-address"
        autoCapitalize="none"
        style={styles.input}
      />

      {/* {!otpSent && !loading && (
        <TouchableOpacity style={styles.btn} onPress={handleSendOtp}>
          <Text style={styles.btnText}>Send OTP</Text>
        </TouchableOpacity>
      )} */}

      {!otpSent && (
        <TouchableOpacity
          style={[styles.btn, loading && { opacity: 0.7 }]}
          onPress={handleSendOtp}
          disabled={loading}
        >
          {loading ? (
            <ActivityIndicator size="small" color="#fff" />
          ) : (
            <Text style={styles.btnText}>Send OTP</Text>
          )}
        </TouchableOpacity>
      )}


      {/* OTP Input */}
      {otpSent && (
        <>
          <TextInput
            value={otp}
            onChangeText={text => setOtp(text.replace(/[^0-9]/g, ''))}
            placeholder="Enter OTP"
            keyboardType="number-pad"
            maxLength={6}
            style={styles.input}
          />

          <TouchableOpacity
            style={[styles.btn, loading && { opacity: 0.7 }]}
            onPress={handleVerifyOtp}
            disabled={loading}
          >
            {loading ? (
              <ActivityIndicator size="small" color="#fff" />
            ) : (
              <Text style={styles.btnText}>Verify & Login</Text>
            )}
          </TouchableOpacity>
        </>
      )}
      <Text style={styles.signupText}>
        Don’t have an account?{' '}
        <Text
          style={styles.signupLink}
          onPress={() => navigation.navigate('Name')}
        >
          Sign up
        </Text>
      </Text>
    </SafeAreaView>
  );
};

export default Login;

const styles = StyleSheet.create({
  mainView: {
    flex: 1,
    justifyContent: 'center',
    padding: 24,
  },

  title: {
    fontSize: 22,
    marginBottom: 30,
    textAlign: 'center',
    fontFamily: 'Poppins-SemiBold',
  },

  input: {
    borderWidth: 1,
    borderColor: '#ccc',
    padding: 14,
    borderRadius: 8,
    fontSize: 16,
    marginBottom: 16,
    fontFamily: 'Poppins-Regular'
  },

  btn: {
    backgroundColor: '#2D6EFF',
    paddingVertical: 14,
    borderRadius: 8,
    alignItems: 'center',
    marginBottom: 10,
  },

  btnText: {
    color: '#fff',
    fontSize: 16,
    fontFamily: "Poppins-SemiBold"
  },
  signupText: {
    textAlign: 'center',
    marginTop: 20,
    fontSize: 14,
    color: '#666',
    fontFamily: "Poppins-SemiBold"
  },

  signupLink: {
    color: '#2D6EFF',
    fontWeight: '700',
    fontFamily: "Poppins-SemiBold"
  },
});
