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

const Mobile = () => {
  const navigation = useNavigation();
  const route = useRoute();
  const { name, email } = route.params;

  const [loading, setLoading] = useState(true);
  const [mobile, setMobile] = useState('');
  const [phoneText, setPhoneText] = useState('');

  // 🔹 Fetch banner
  const fetchRegisterContent = async () => {
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

  const handleNext = () => {
    if (!mobile.trim()) {
      Alert.alert('Error', 'Please enter your mobile number');
      return;
    }

    if (mobile.length !== 10) {
      Alert.alert('Error', 'Mobile number must be 10 digits');
      return;
    }

    navigation.navigate('Location', { name, email, mobile });
  };

  return (
    <SafeAreaView style={styles.mainView}>
      <StatusBar barStyle="dark-content" />

      <KeyboardAvoidingView
        style={{ flex: 1 }}
        behavior={Platform.OS === 'ios' ? 'padding' : 'height'}
      >
        <ScrollView
          contentContainerStyle={styles.scrollContent}
          keyboardShouldPersistTaps="handled"
          showsVerticalScrollIndicator={false}
        >
          {/* 🔹 Banner (FIXED HEIGHT) */}
          <View style={styles.bannerWrapper}>
            {loading ? (
              <ActivityIndicator size="large" color="#2D6EFF" />
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

          {/* 🔹 Input Section (SAME UI AS OLD) */}
          <View style={styles.inputContainer}>
            <Text style={styles.title}>Mobile</Text>

            <TextInput
              value={mobile}
              onChangeText={text =>
                setMobile(text.replace(/[^0-9]/g, ''))
              }
              placeholder="Enter your Mobile No"
              keyboardType="number-pad"
              maxLength={10}
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

export default Mobile;
const styles = StyleSheet.create({
  mainView: {
    flex: 1,
    backgroundColor: '#F5F5F5',
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
    height: '100%',
  },

  inputContainer: {
    width: '90%', // ✅ SAME AS OLD SCREEN
    marginTop: 20,
  },

  title: {
    fontSize: 18,
    fontWeight: '500',
    marginBottom: 8,
    fontFamily: 'Poppins-Regular',
    color: '#333',
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
    marginTop: 40,
    backgroundColor: '#2D6EFF',
    paddingVertical: 14,
    borderRadius: 8,
    alignItems: 'center',
  },

  nextText: {
    color: '#fff',
    fontSize: 16,
    fontWeight: '600',
    fontFamily: 'Poppins-Regular',
  },
});
