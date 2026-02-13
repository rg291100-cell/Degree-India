// api.js
import axios from 'axios';
import AsyncStorage from '@react-native-async-storage/async-storage';

export const BASE_URL = 'https://argosmob.uk/degree-india/public/api';
export const BASE_IMAGE_URL = 'https://argosmob.uk/degree-india/storage/app/public/';

// ✅ Common GET API
export const getApi = async (endpoint, auth = true) => {
  try {
    const headers = {
      'Content-Type': 'application/json',
      'Accept': 'application/json'
    };

    if (auth) {
      const token = await AsyncStorage.getItem('AUTH_TOKEN'); // <- get token here
      console.log("Token retrieved for GET:", token ? "YES" : "NO");

      if (token) headers.Authorization = `Bearer ${token}`;
    }

    console.log(`GET Request: ${BASE_URL}${endpoint}`);
    const response = await axios.get(`${BASE_URL}${endpoint}`, { headers });
    return response.data;
  } catch (error) {
    console.log(`GET API Error [${endpoint}]:`, error.response?.data || error.message);
    throw error;
  }
};

// ✅ Common POST API
export const postApi = async (endpoint, payload, auth = true) => {
  try {
    const headers = {
      'Content-Type': 'application/json',
      'Accept': 'application/json'
    };

    if (auth) {
      const token = await AsyncStorage.getItem('AUTH_TOKEN'); // <- get token here
      console.log("Token retrieved for POST:", token ? "YES" : "NO");
      if (token) headers.Authorization = `Bearer ${token}`;
    }

    console.log(`POST Request: ${BASE_URL}${endpoint}`);
    console.log('Payload:', JSON.stringify(payload));

    const response = await axios.post(`${BASE_URL}${endpoint}`, payload, { headers });
    return response.data;
  } catch (error) {
    console.log(`POST API Error [${endpoint}]:`, error.response?.data || error.message);
    throw error;
  }
};
