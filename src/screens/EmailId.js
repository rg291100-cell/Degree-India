import React, { useEffect, useState } from 'react';
import {
  View,
  Text,
  StyleSheet,
  StatusBar,
  TextInput,
  TouchableOpacity,
  Alert,
  ActivityIndicator,
  Image,
  KeyboardAvoidingView,
  Platform,
  ScrollView,
} from 'react-native';
import { useNavigation, useRoute } from '@react-navigation/native';
import { SafeAreaView } from 'react-native-safe-area-context';
import { getApi } from '../config/api';

const EmailId = () => {
  const navigation = useNavigation();
  const route = useRoute();
  const { name } = route.params;

  const [loading, setLoading] = useState(false);
  const [email, setEmail] = useState('');
  const [phoneText, setPhoneText] = useState('');

  // 🔹 Fetch banner image
  const fetchRegisterContent = async () => {
    setLoading(true);
    try {
      const response = await getApi('/register-content', false);
      setPhoneText(response?.data?.[0]?.phone_image || '');
    } catch (error) {
      Alert.alert('Error', 'Something went wrong');
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchRegisterContent();
  }, []);

  // 🔹 Email validation & navigation
  const handleNext = () => {
    if (!email.trim()) {
      Alert.alert('Validation', 'Please enter your email');
      return;
    }

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
      Alert.alert('Validation', 'Please enter a valid email');
      return;
    }

    navigation.navigate('Mobile', {
      name,
      email,
    });
  };

  return (
    <SafeAreaView style={styles.mainView}>
      <StatusBar barStyle="dark-content" />

      <KeyboardAvoidingView
        style={styles.keyboardView}
        behavior={Platform.OS === 'ios' ? 'padding' : 'height'}
      >
        <ScrollView
          contentContainerStyle={styles.scrollContent}
          keyboardShouldPersistTaps="handled"
          showsVerticalScrollIndicator={false}
        >
          {/* 🔹 Banner Image */}
          <View style={styles.bannerWrapper}>
            {loading ? (
              <ActivityIndicator size="large" />
            ) : phoneText ? (
              <Image
                source={{
                  uri: `https://argosmob.uk/degree-india/storage/app/public/${phoneText}`,
                }}
                style={styles.headerImage}
                resizeMode="cover"
              />
            ) : null}
          </View>

          {/* 🔹 Input Section */}
          <View style={styles.inputContainer}>
            <Text style={styles.title}>Email</Text>

            <TextInput
              value={email}
              onChangeText={setEmail}
              placeholder="Enter your email"
              keyboardType="email-address"
              autoCapitalize="none"
              style={styles.input}
              returnKeyType="done"
            />

            <TouchableOpacity style={styles.nextBtn} onPress={handleNext}>
              <Text style={styles.nextText}>Next</Text>
            </TouchableOpacity>
          </View>
        </ScrollView>
      </KeyboardAvoidingView>
    </SafeAreaView>
  );
};

export default EmailId;

const styles = StyleSheet.create({
  mainView: {
    flex: 1,
    backgroundColor: '#F5F5F5',
  },
  keyboardView: {
    flex: 1,
  },
  scrollContent: {
    flexGrow: 1,
    alignItems: 'center',
    paddingBottom: 40,
  },
  bannerWrapper: {
    width: '100%',
    height: 250,
    justifyContent: 'center',
    alignItems: 'center',
    backgroundColor: '#EAEAEA',
  },
  headerImage: {
    width: '100%',
    height: 250,
  },
  inputContainer: {
    width: '90%',
    marginTop: 20,
  },
  title: {
    fontSize: 18,
    marginBottom: 8,
    color: '#333',
    fontFamily: 'Poppins-Regular',
  },
  input: {
    borderWidth: 1,
    borderColor: '#ccc',
    padding: 12,
    borderRadius: 8,
    fontSize: 16,
    backgroundColor: '#fff',
    fontFamily: 'Poppins-Regular',
  },
  nextBtn: {
    marginTop: 20,
    backgroundColor: '#2D6EFF',
    paddingVertical: 14,
    borderRadius: 8,
    alignItems: 'center',
  },
  nextText: {
    color: '#fff',
    fontSize: 16,
    fontFamily: 'Poppins-SemiBold',
  },
});
