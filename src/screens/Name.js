import React, { useState, useEffect } from 'react';
import {
  View,
  Text,
  StyleSheet,
  StatusBar,
  TextInput,
  TouchableOpacity,
  ActivityIndicator,
  Alert,
  Image,
  KeyboardAvoidingView,
  Platform,
  ScrollView,
} from 'react-native';
import { SafeAreaView } from 'react-native-safe-area-context';
import { useNavigation } from '@react-navigation/native';
import { getApi } from '../config/api';

const Name = () => {
  const navigation = useNavigation();

  const [name, setName] = useState('');
  const [loading, setLoading] = useState(false);
  const [nameText, setNameText] = useState('');

  // 🔹 Fetch register content from API
  const fetchRegisterContent = async () => {
    setLoading(true);
    try {
      const response = await getApi('/register-content', false);
      const apiNameText = response?.data?.[0]?.name_image;
      setNameText(apiNameText);
    } catch (error) {
      Alert.alert(
        'Error',
        error.response?.data?.message || 'Something went wrong',
      );
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchRegisterContent();
  }, []);

  // 🔹 Handle Next Button
  const handleNext = () => {
    if (!name.trim()) {
      Alert.alert('Validation', 'Please enter your name');
      return;
    }
    navigation.navigate('EmailId', { name });
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
          {/* Image Section */}
          {/* {loading ? (
            <ActivityIndicator size="large" style={styles.loader} />
          ) : nameText ? (
            <View style={styles.imageContainer}>
              <Image
                source={{
                  uri: `https://argosmob.uk/degree-india/storage/app/public/${nameText}`,
                }}
                style={styles.headerImage}
                resizeMode="cover"
              />
            </View>
          ) : null} */}
          <View style={styles.bannerWrapper}>
  {loading ? (
    <ActivityIndicator size="large" color="#2D6EFF" />
  ) : nameText ? (
    <Image
      source={{
        uri: `https://argosmob.uk/degree-india/storage/app/public/${nameText}`,
      }}
      style={styles.headerImage}
      resizeMode="cover"
    />
  ) : null}
</View>

          {/* Input Section */}
          <View style={styles.inputContainer}>
            <Text style={styles.title}>Your Name</Text>

            <TextInput
              value={name}
              onChangeText={setName}
              placeholder="Enter your name"
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

export default Name;

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

  loader: {
    marginVertical: 20,
  },

  imageContainer: {
    width: '100%',
    marginBottom: 10,
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
    fontWeight: '500',
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
    fontWeight: '600',
    fontFamily: 'Poppins-SemiBold',
  },
  bannerWrapper: {
  width: '100%',
  height: 250,            // 🔑 same as banner height
  justifyContent: 'center',
  alignItems: 'center',
  backgroundColor: '#EAEAEA', // optional placeholder bg
},

});
