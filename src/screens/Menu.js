import React from 'react';
import {
  View,
  Text,
  StatusBar,
  StyleSheet,
  TouchableOpacity,
  Alert,
  Linking,
} from 'react-native';
import { SafeAreaView } from 'react-native-safe-area-context';
import Icon from 'react-native-vector-icons/MaterialCommunityIcons';
import { useNavigation } from '@react-navigation/native';

const Menu = () => {
  const navigation = useNavigation();

  const MenuItem = ({ icon, title, onPress, danger }) => (
    <TouchableOpacity style={styles.item} onPress={onPress}>
      <View style={styles.itemLeft}>
        <Icon name={icon} size={22} color={danger ? '#E53935' : '#444'} />
        <Text style={[styles.itemText, danger && { color: '#E53935' }]}>
          {title}
        </Text>
      </View>
      {!danger && <Icon name="chevron-right" size={22} color="#999" />}
    </TouchableOpacity>
  );

  const handleLogout = () => {
    Alert.alert('Logout', 'Are you sure you want to logout?', [
      { text: 'Cancel', style: 'cancel' },
      {
        text: 'Logout',
        style: 'destructive',
        onPress: () => {
          navigation.replace('Login');
        },
      },
    ]);
  };

  const handleCallPress = () => {
    const phoneNumber = 'tel:+1234567890'; 
    Linking.openURL(phoneNumber).catch(err => {
      Alert.alert('Error', 'Unable to open dialer');
      console.error('Error opening dialer:', err);
    });
  };

  return (
    <SafeAreaView style={styles.container}>
      <StatusBar barStyle="dark-content" backgroundColor="#fff" />

      <Text style={styles.heading}>Menu</Text>

      <View style={styles.card}>
        <MenuItem
          icon="home-outline"
          title="Home"
          onPress={() => navigation.navigate('Home')}
        />

        <MenuItem
          icon="account-outline"
          title="Profile"
          onPress={() => navigation.navigate('Profile')}
        />

        <MenuItem
          icon="phone-outline"
          title="Contact Us"
          onPress={handleCallPress}
        />

        <MenuItem
          icon="bell-outline"
          title="Notifications"
          onPress={() => navigation.navigate('Notification')}
        />
      </View>

      <View style={styles.card}>
        <MenuItem icon="logout" title="Logout" danger onPress={handleLogout} />
      </View>
    </SafeAreaView>
  );
};

export default Menu;

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#fff',
    paddingHorizontal: 16,
  },

  heading: {
    fontSize: 22,
    fontFamily: 'Poppins-SemiBold',
    color: '#000',
    marginVertical: 20,
    textAlign: 'center',
  },

  card: {
    backgroundColor: '#fff',
    borderRadius: 12,
    elevation: 3,
    marginBottom: 20,
    paddingVertical: 4,
  },

  item: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    paddingVertical: 14,
    paddingHorizontal: 16,
    borderBottomWidth: 0.5,
    borderBottomColor: '#eee',
  },

  itemLeft: {
    flexDirection: 'row',
    alignItems: 'center',
  },

  itemText: {
    fontSize: 16,
    marginLeft: 12,
    color: '#333',
    fontFamily: 'Poppins-Regular',
  },
});
