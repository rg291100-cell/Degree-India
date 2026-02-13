import React, { useState } from 'react';
import {
  View,
  Text,
  StyleSheet,
  TouchableOpacity,
  ScrollView,
  Alert,
  ActivityIndicator
} from 'react-native';
import Icon from 'react-native-vector-icons/MaterialIcons';
import { useNavigation } from '@react-navigation/native';
import CustomPicker from '../screens/CustomPicker';
import { SafeAreaView } from 'react-native-safe-area-context';
// import { postApi } from '../config/api'; // Uncomment if endpoint is known

const BookYour = () => {
  const navigation = useNavigation();

  // States
  const [month, setMonth] = useState('Select Month');
  const [year, setYear] = useState('Select Year');
  const [slot, setSlot] = useState('Book Your Slot');
  const [language, setLanguage] = useState('Select Language');
  const [loading, setLoading] = useState(false);

  // Picker Control
  const [showPicker, setShowPicker] = useState(false);
  const [pickerTitle, setPickerTitle] = useState('');
  const [pickerData, setPickerData] = useState([]);
  const [pickerSetter, setPickerSetter] = useState(() => { });

  // Lists
  const months = [
    'January', 'February', 'March', 'April', 'May', 'June',
    'July', 'August', 'September', 'October', 'November', 'December',
  ];

  const years = Array.from({ length: 5 }, (_, i) => `${new Date().getFullYear() + i}`);

  const slots = ['Morning (9-12)', 'Afternoon (12-3)', 'Evening (3-6)', 'Night (6-9)'];

  const languages = [
    'English', 'Hindi', 'Tamil', 'Telugu', 'Marathi', 'Gujarati',
  ];

  // Function to open picker
  const openPicker = (title, list, setter) => {
    setPickerTitle(title);
    setPickerData(list);
    setPickerSetter(() => setter);
    setShowPicker(true);
  };

  const handleSelect = (val) => {
    pickerSetter(val);
    setShowPicker(false);
  }

  const handleSubmit = async () => {
    if (month === 'Select Month' || year === 'Select Year' || slot === 'Book Your Slot' || language === 'Select Language') {
      Alert.alert('Validation Error', 'Please select all fields to book a session.');
      return;
    }

    setLoading(true);

    // Simulate API call for now (or replace with actual API)
    setTimeout(() => {
      console.log('Booking Data:', { month, year, slot, language });
      setLoading(false);
      Alert.alert(
        'Success',
        'Your session request has been received. Our team will contact you shortly.',
        [{ text: 'OK', onPress: () => navigation.goBack() }]
      );
    }, 1500);

    /* 
    try {
        await postApi('/book-session', { month, year, slot, language });
        Alert.alert('Success', 'Booked!');
        navigation.goBack();
    } catch (e) {
        Alert.alert('Error', 'Booking failed');
    } finally {
        setLoading(false);
    }
    */
  };

  return (
    <SafeAreaView style={styles.safe}>
      <ScrollView style={styles.container} showsVerticalScrollIndicator={false}>
        {/* Header */}
        <View style={styles.header}>
          <TouchableOpacity onPress={() => navigation.goBack()}>
            <Icon name="arrow-back" size={26} color="#000" />
          </TouchableOpacity>

          <Text style={styles.headerTitle}>Book Your Session</Text>
          <View />
        </View>

        {/* Start Date */}
        <Text style={styles.label}>Start Date</Text>

        <View style={styles.row}>
          <TouchableOpacity
            style={styles.dropdown}
            onPress={() => openPicker('Select Month', months, setMonth)}
          >
            <Text style={styles.dropdownText}>{month}</Text>
            <Icon name="arrow-drop-down" size={26} color="#000" />
          </TouchableOpacity>

          <TouchableOpacity
            style={styles.dropdown}
            onPress={() => openPicker('Select Year', years, setYear)}
          >
            <Text style={styles.dropdownText}>{year}</Text>
            <Icon name="arrow-drop-down" size={26} color="#000" />
          </TouchableOpacity>
        </View>

        {/* Slot */}
        <Text style={styles.label}>Book Slot</Text>

        <TouchableOpacity
          style={styles.fullDropdown}
          onPress={() => openPicker('Select Slot', slots, setSlot)}
        >
          <Text style={styles.dropdownText}>{slot}</Text>
          <Icon name="arrow-drop-down" size={26} color="#000" />
        </TouchableOpacity>

        {/* Language */}
        <Text style={styles.label}>Select Language</Text>

        <TouchableOpacity
          style={styles.fullDropdown}
          onPress={() => openPicker('Select Language', languages, setLanguage)}
        >
          <Text style={styles.dropdownText}>{language}</Text>
          <Icon name="arrow-drop-down" size={26} color="#000" />
        </TouchableOpacity>

        {/* Rules */}
        <Text style={[styles.label, { marginTop: 15 }]}>
          Rules And Regulations
        </Text>

        <View style={styles.rulesList}>
          {['Ensure stable internet connection.', 'Be ready 10 mins prior.', 'Keep notepad handy.', 'Cancellations 24h prior.'].map((r, i) => (
            <Text key={i} style={styles.ruleText}>
              {i + 1}. {r}
            </Text>
          ))}
        </View>

        <TouchableOpacity
          style={[styles.submitButton, loading && { opacity: 0.7 }]}
          onPress={handleSubmit}
          disabled={loading}
        >
          {loading ? (
            <ActivityIndicator color="#fff" />
          ) : (
            <Text style={styles.submitText}>Submit</Text>
          )}
        </TouchableOpacity>
      </ScrollView>

      {/* Re-integrated CustomPicker logic using simple Modal or similar if CustomPicker is not perfectly linked, 
          but here assuming CustomPicker logic inside the component or simple local state View for simplicity 
          if CustomPicker import is iffy. 
          Actually, I will use a simple overlay if CustomPicker is complex. 
          But sticking to the original structure with a small inline picker view if needed.
      */}
      {showPicker && (
        <View style={styles.pickerOverlay}>
          <View style={styles.pickerContainer}>
            <Text style={styles.pickerHeader}>{pickerTitle}</Text>
            <ScrollView style={{ maxHeight: 300 }}>
              {pickerData.map((item, idx) => (
                <TouchableOpacity
                  key={idx}
                  style={styles.pickerItem}
                  onPress={() => handleSelect(item)}
                >
                  <Text style={styles.pickerItemText}>{item}</Text>
                </TouchableOpacity>
              ))}
            </ScrollView>
            <TouchableOpacity onPress={() => setShowPicker(false)} style={styles.closePicker}>
              <Text style={{ color: 'red', textAlign: 'center' }}>Close</Text>
            </TouchableOpacity>
          </View>
        </View>
      )}

    </SafeAreaView>
  );
};

export default BookYour;

const styles = StyleSheet.create({
  safe: {
    flex: 1,
    backgroundColor: '#fff',
  },

  container: {
    flex: 1,
    paddingHorizontal: 20,
    paddingTop: 10,
  },

  header: {
    flexDirection: 'row',
    alignItems: 'center',
    marginBottom: 15,
    justifyContent: 'space-between',
  },

  headerTitle: {
    fontSize: 20,
    color: '#000',
    marginLeft: 12,
    fontFamily: 'Poppins-SemiBold',
  },

  label: {
    fontSize: 15,
    fontWeight: '600',
    color: '#000',
    marginBottom: 8,
    marginTop: 10,
    fontFamily: 'Poppins-Black',
  },

  row: {
    flexDirection: 'row',
    justifyContent: 'space-between',
  },

  dropdown: {
    width: '48%',
    borderWidth: 1,
    borderColor: '#d0d0d0',
    borderRadius: 10,
    paddingVertical: 12,
    paddingHorizontal: 14,
    backgroundColor: '#fafafa',
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
    marginBottom: 15,
  },

  fullDropdown: {
    borderWidth: 1,
    borderColor: '#d0d0d0',
    borderRadius: 10,
    paddingVertical: 12,
    paddingHorizontal: 14,
    backgroundColor: '#fafafa',
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
    marginBottom: 15,
  },

  dropdownText: {
    fontSize: 14,
    color: '#333',
    fontFamily: 'Poppins-Regular',
  },

  rulesList: {
    marginBottom: 20,
    fontFamily: 'Poppins-Regular',
  },

  ruleText: {
    fontSize: 14,
    color: '#444',
    marginVertical: 4,
  },

  submitButton: {
    backgroundColor: '#000',
    borderRadius: 10,
    paddingVertical: 14,
    alignItems: 'center',
    marginBottom: 50,
  },

  submitText: {
    fontSize: 16,
    fontWeight: '700',
    color: '#fff',
  },
  pickerOverlay: {
    position: 'absolute',
    top: 0, bottom: 0, left: 0, right: 0,
    backgroundColor: 'rgba(0,0,0,0.5)',
    justifyContent: 'center',
    alignItems: 'center'
  },
  pickerContainer: {
    width: '80%',
    backgroundColor: '#fff',
    borderRadius: 10,
    padding: 20,
    maxHeight: '60%'
  },
  pickerHeader: {
    fontSize: 18,
    fontWeight: 'bold',
    marginBottom: 10,
    textAlign: 'center'
  },
  pickerItem: {
    paddingVertical: 12,
    borderBottomWidth: 1,
    borderBottomColor: '#eee'
  },
  pickerItemText: {
    fontSize: 16,
    textAlign: 'center'
  },
  closePicker: {
    marginTop: 15,
    padding: 10
  }
});
