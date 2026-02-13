import React, { useState, useEffect } from 'react';
import {
  View,
  Text,
  StyleSheet,
  Image,
  TextInput,
  TouchableOpacity,
  ScrollView,
  Alert,
  Platform,
  PermissionsAndroid
} from 'react-native';
import { SafeAreaView } from 'react-native-safe-area-context';
import { useNavigation } from '@react-navigation/native';
import Icon from 'react-native-vector-icons/MaterialIcons';
import { getApi, BASE_URL, BASE_IMAGE_URL } from '../config/api';
import axios from 'axios';
import AsyncStorage from '@react-native-async-storage/async-storage';
import * as ImagePicker from 'react-native-image-picker';

const Profile = () => {
  const navigation = useNavigation();

  const [profileData, setProfileData] = useState({
    name: '',
    email: '',
    phone: '',
    bio: '',
    profilePic: '',
  });

  const [editing, setEditing] = useState(false);
  const [uploadingPic, setUploadingPic] = useState(false);


  const requestGalleryPermission = async () => {
    if (Platform.OS !== 'android') return true;

    try {
      const granted = await PermissionsAndroid.request(
        PermissionsAndroid.PERMISSIONS.READ_MEDIA_IMAGES ||
        PermissionsAndroid.PERMISSIONS.READ_EXTERNAL_STORAGE,
        {
          title: 'Gallery Permission',
          message: 'App needs access to your photos',
          buttonPositive: 'OK',
        },
      );

      return granted === PermissionsAndroid.RESULTS.GRANTED;
    } catch (err) {
      console.warn(err);
      return false;
    }
  };


  // 🔹 Fetch profile
  const getProfile = async () => {
    try {
      const data = await getApi('/profile/get');
      setProfileData({
        name: data?.user?.name || '',
        email: data?.user?.email || '',
        phone: data?.user?.phone || '',
        bio: data?.user?.bio || '',
        profilePic: data?.user?.profile_picture || '',
      });
    } catch (error) {
      Alert.alert('Error', 'Unable to fetch profile.');
    }
  };

  useEffect(() => {
    getProfile();
  }, []);

  // 🔹 Pick image first
  // const handlePickProfilePic = () => {
  //   ImagePicker.launchImageLibrary(
  //     { mediaType: 'photo', quality: 0.7 },
  //     response => {
  //       if (response.didCancel) return;

  //       if (response.errorCode) {
  //         Alert.alert('Error', response.errorMessage);
  //         return;
  //       }

  //       if (!response.assets || !response.assets.length) {
  //         Alert.alert('Error', 'No image selected');
  //         return;
  //       }

  //       const uri = response.assets[0].uri;
  //       handleUploadProfilePic(uri);
  //     },
  //   );
  // };
  const handlePickProfilePic = async () => {
    const hasPermission = await requestGalleryPermission();
    if (!hasPermission) {
      Alert.alert('Permission denied', 'Gallery access is required');
      return;
    }

    ImagePicker.launchImageLibrary(
      {
        mediaType: 'photo',
        quality: 0.7,
        selectionLimit: 1,
      },
      response => {
        if (response.didCancel) return;

        if (response.errorCode) {
          console.log('ImagePicker Error:', response.errorMessage);
          return;
        }

        if (!response.assets || !response.assets.length) return;

        const uri = response.assets[0].uri;
        handleUploadProfilePic(uri);
      },
    );
  };

  // 🔹 Upload image
  const handleUploadProfilePic = async uri => {
    try {
      setUploadingPic(true);

      const token = await AsyncStorage.getItem('AUTH_TOKEN');
      if (!token) {
        Alert.alert('Error', 'Authentication token missing');
        return;
      }

      const filename = uri.split('/').pop();
      const ext = filename.split('.').pop();

      const formData = new FormData();
      formData.append('profile_image', {
        uri: Platform.OS === 'ios' ? uri.replace('file://', '') : uri,
        name: filename,
        type: `image/${ext}`,
      });

      await axios.post(
        `${BASE_URL}/profile/update-image`,
        formData,
        {
          headers: {
            Authorization: `Bearer ${token}`,
            'Content-Type': 'multipart/form-data',
            Accept: 'application/json',
          },
        },
      );

      await getProfile();
      Alert.alert('Success', 'Profile picture updated');
    } catch (err) {
      Alert.alert('Error', 'Image upload failed');
    } finally {
      setUploadingPic(false);
    }
  };

  // 🔹 Submit profile update
  const handleSubmit = async () => {
    try {
      const token = await AsyncStorage.getItem('AUTH_TOKEN');
      if (!token) return Alert.alert('Error', 'No token found');

      const data = new URLSearchParams();
      data.append('name', profileData.name);
      data.append('email', profileData.email);
      data.append('phone', profileData.phone);
      data.append('bio', profileData.bio || '');

      await axios.post(`${BASE_URL}/profile/update`, data.toString(), {
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
          Authorization: `Bearer ${token}`,
          Accept: 'application/json',
        },
      });

      await getProfile();
      Alert.alert('Success', 'Profile updated!');
      setEditing(false);
    } catch (error) {
      Alert.alert('Error', 'Failed to update profile');
    }
  };

  return (
    <SafeAreaView style={styles.container}>
      {/* Header */}
      <View style={styles.header}>
        <TouchableOpacity onPress={() => navigation.goBack()}>
          <Icon name="arrow-back" size={24} color="#000" />
        </TouchableOpacity>
        <Text style={styles.headerTitle}>Profile</Text>
        <View style={{ width: 24 }} />
      </View>

      <ScrollView contentContainerStyle={styles.content}>
        {/* Profile Picture */}
        <TouchableOpacity
          onPress={editing ? handlePickProfilePic : null}
        >
          <Image
            source={{
              uri: profileData.profilePic
                ? `${BASE_IMAGE_URL}${profileData.profilePic}`
                : 'https://i.pravatar.cc/150?img=3',
            }}
            style={styles.profilePic}
          />
        </TouchableOpacity>

        {uploadingPic && <Text style={{
          marginTop: 10, fontFamily: 'Poppins-Regular'
        }}>Uploading...</Text>}

        {/* Profile Info */}
        <View style={styles.infoContainer}>
          <Text style={styles.label}>Name</Text>
          <TextInput
            style={styles.input}
            value={profileData.name}
            editable={editing}
            onChangeText={text =>
              setProfileData({ ...profileData, name: text })
            }
          />

          <Text style={styles.label}>Email</Text>
          <TextInput
            style={styles.input}
            value={profileData.email}
            editable={editing}
            onChangeText={text =>
              setProfileData({ ...profileData, email: text })
            }
          />

          <Text style={styles.label}>Phone</Text>
          <TextInput
            style={styles.input}
            value={profileData.phone}
            editable={editing}
            onChangeText={text =>
              setProfileData({ ...profileData, phone: text })
            }
          />

          {/* <Text style={styles.label}>Bio</Text>
          <TextInput
            style={[styles.input, { height: 80 }]}
            value={profileData.bio}
            editable={editing}
            onChangeText={text =>
              setProfileData({ ...profileData, bio: text })
            }
            multiline
          /> */}

          <TouchableOpacity
            style={[
              styles.button,
              { backgroundColor: editing ? '#4CAF50' : '#2196F3' },
            ]}
            onPress={editing ? handleSubmit : () => setEditing(true)}
          >
            <Text style={styles.buttonText}>
              {editing ? 'Save' : 'Edit Profile'}
            </Text>
          </TouchableOpacity>
        </View>
      </ScrollView>
    </SafeAreaView>
  );
};

export default Profile;

const styles = StyleSheet.create({
  container: { flex: 1, backgroundColor: '#f2f2f2' },
  header: {
    flexDirection: 'row',
    alignItems: 'center',
    paddingHorizontal: 15,
    paddingVertical: 12,
  },
  headerTitle: {
    flex: 1,
    textAlign: 'center',
    fontSize: 18,
    fontFamily: 'Poppins-SemiBold',
  },
  content: { padding: 20, alignItems: 'center' },
  profilePic: { width: 120, height: 120, borderRadius: 60 },
  infoContainer: { width: '100%' },
  label: { marginTop: 10, fontFamily: 'Poppins-Regular' },
  input: {
    borderWidth: 1,
    borderColor: '#ccc',
    borderRadius: 8,
    padding: 10,
    backgroundColor: '#fff',
    fontFamily: 'Poppins-Regular'
  },
  button: {
    marginTop: 20,
    paddingVertical: 15,
    borderRadius: 8,
    alignItems: 'center',
  },
  buttonText: { color: '#fff', fontFamily: 'Poppins-SemiBold' },
});
