import React from 'react';
import {
  View,
  Text,
  StyleSheet,
  ScrollView,
  TouchableOpacity,
} from 'react-native';
import { SafeAreaView } from 'react-native-safe-area-context';
import { useNavigation } from '@react-navigation/native';
import Icon from 'react-native-vector-icons/MaterialIcons';

const notificationsData = [
  { id: 1, title: 'New Message', description: 'You have received a new message.' },
  { id: 2, title: 'App Update', description: 'A new version of the app is available.' },
  { id: 3, title: 'Promotion', description: 'Check out our latest offers!' },
  { id: 4, title: 'Reminder', description: 'Don’t forget your upcoming appointment.' },
];

const Notification = () => {
  const navigation = useNavigation();

  return (
    <SafeAreaView style={styles.container}>
      {/* Header */}
      <View style={styles.header}>
        {/* <TouchableOpacity onPress={() => navigation.goBack()}> */}
        {/* <TouchableOpacity onPress={() => navigation.navigate('Home')}>
          <Icon name="arrow-back" size={24} color="#000" />
        </TouchableOpacity> */}
        <Text style={styles.headerTitle}>Notifications</Text>
        <View style={{ width: 24 }} />
      </View>

      {/* Notifications List */}
      <ScrollView contentContainerStyle={styles.content}>
        {notificationsData.map((item) => (
          <View key={item.id} style={styles.notificationCard}>
            <Text style={styles.notificationTitle}>{item.title}</Text>
            <Text style={styles.notificationDescription}>{item.description}</Text>
          </View>
        ))}
      </ScrollView>
    </SafeAreaView>
  );
};

export default Notification;

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#f2f2f2',
  },
  header: {
    flexDirection: 'row',
    alignItems: 'center',
    paddingHorizontal: 15,
    paddingVertical: 12,
  },
  headerTitle: {
    flex: 1,
    textAlign: 'center',
    color: '#000',
    fontSize: 18,
    fontWeight: '500',
    fontFamily: 'Poppins-SemiBold',
  },
  content: {
    paddingBottom: 20,
    paddingHorizontal:20
  },
  notificationCard: {
    backgroundColor: '#fff',
    padding: 15,
    borderRadius: 10,
    marginBottom: 15,
    shadowColor: '#000',
    shadowOpacity: 0.05,
    shadowRadius: 5,
    elevation: 2,
  },
  notificationTitle: {
    fontSize: 16,
    fontWeight: '500',
    marginBottom: 4,
    fontFamily: 'Poppins-Regular',
  },
  notificationDescription: {
    fontSize: 14,
    color: '#555',
         fontFamily: 'Poppins-Regular',

  },
});
