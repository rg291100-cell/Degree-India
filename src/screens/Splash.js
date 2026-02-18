import React, { Component, useEffect } from 'react';
import { View, Text, StyleSheet, StatusBar } from 'react-native';
import AsyncStorage from '@react-native-async-storage/async-storage';
import { SafeAreaView } from 'react-native-safe-area-context';

const Splash = ({ navigation }) => {
  // ... (existing code for checkAuth)

  const checkAuth = async () => {
    try {
      // Optional: Add a minimum splash duration for better UX
      await new Promise(resolve => setTimeout(resolve, 1500));

      const token = await AsyncStorage.getItem('AUTH_TOKEN');
      console.log("Splash Token:", token);

      if (token && token !== '') {
        // ✅ Token exists → go to TabNavigation with Home as initial screen
        navigation.reset({
          index: 0,
          routes: [
            {
              name: 'TabNavigation',
              state: {
                routes: [{ name: 'Home' }],
                index: 0,
              },
            },
          ],
        });
      } else {
        // ❌ No token → go to Login
        navigation.reset({
          index: 0,
          routes: [{ name: 'Login' }],
        });
      }
    } catch (error) {
      console.log('Auth check error:', error);
      navigation.replace('Login');
    }
  };

  useEffect(() => {
    checkAuth();
  }, []);


  return (
    <SafeAreaView style={styles.container}>
      <StatusBar barStyle="light-content" backgroundColor="#FF3D00" />
      <Text style={styles.appName}>Degree India</Text>
    </SafeAreaView>
  );
};


const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#FF3D00',
    justifyContent: 'center',
    alignItems: 'center',
  },
  appName: {
    fontSize: 32,
    color: '#fff',
    fontFamily: 'Poppins-Black',
  },
});

export default Splash;
