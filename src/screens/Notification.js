import React, { useEffect, useState } from 'react';
import {
  View,
  Text,
  StyleSheet,
  ScrollView,
  TouchableOpacity,
  ActivityIndicator,
  RefreshControl,
} from 'react-native';
import { SafeAreaView } from 'react-native-safe-area-context';
import { useNavigation } from '@react-navigation/native';
import Icon from 'react-native-vector-icons/MaterialIcons';
import { getApi } from '../config/api';

const Notification = () => {
  const navigation = useNavigation();
  const [notifications, setNotifications] = useState([]);
  const [loading, setLoading] = useState(true);
  const [refreshing, setRefreshing] = useState(false);

  const fetchNotifications = async () => {
    try {
      setLoading(true);
      const res = await getApi('/notifications', true);
      if (res?.success) {
        setNotifications(res.notifications || []);
      }
    } catch (error) {
      console.log('Error fetching notifications:', error);
    } finally {
      setLoading(false);
      setRefreshing(false);
    }
  };

  useEffect(() => {
    fetchNotifications();
  }, []);

  const onRefresh = () => {
    setRefreshing(true);
    fetchNotifications();
  };

  const formatDateTime = (dateStr) => {
    if (!dateStr) return '';
    const date = new Date(dateStr);
    return date.toLocaleDateString('en-IN', {
      day: '2-digit',
      month: 'short',
      year: 'numeric',
      hour: '2-digit',
      minute: '2-digit',
    });
  };

  return (
    <SafeAreaView style={styles.container}>
      {/* Header */}
      <View style={styles.header}>
        <TouchableOpacity onPress={() => navigation.goBack()} style={styles.backBtn}>
          <Icon name="arrow-back" size={24} color="#000" />
        </TouchableOpacity>
        <Text style={styles.headerTitle}>Notifications</Text>
        <View style={{ width: 40 }} />
      </View>

      {/* Notifications List */}
      <ScrollView
        contentContainerStyle={styles.content}
        showsVerticalScrollIndicator={false}
        refreshControl={
          <RefreshControl refreshing={refreshing} onRefresh={onRefresh} color="#00BDD6" />
        }
      >
        {loading && !refreshing ? (
          <View style={styles.loaderContainer}>
            <ActivityIndicator size="large" color="#00BDD6" />
            <Text style={styles.loaderText}>Checking for updates...</Text>
          </View>
        ) : notifications.length > 0 ? (
          notifications.map((item) => (
            <View key={item.id} style={styles.notificationCard}>
              <View style={styles.cardHeader}>
                <View style={styles.iconCircle}>
                  <Icon name="notifications" size={20} color="#00BDD6" />
                </View>
                <Text style={styles.notificationTitle}>{item.title}</Text>
              </View>
              <Text style={styles.notificationDescription}>{item.message}</Text>
              <Text style={styles.notificationTime}>{formatDateTime(item.created_at)}</Text>
            </View>
          ))
        ) : (
          <View style={styles.emptyContainer}>
            <Icon name="notifications-none" size={60} color="#ccc" />
            <Text style={styles.emptyText}>No notifications yet</Text>
          </View>
        )}
      </ScrollView>
    </SafeAreaView>
  );
};

export default Notification;

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#F8FAFF',
  },
  header: {
    flexDirection: 'row',
    alignItems: 'center',
    paddingHorizontal: 15,
    paddingVertical: 12,
    backgroundColor: '#fff',
    elevation: 2,
    shadowColor: '#000',
    shadowOpacity: 0.05,
    shadowOffset: { width: 0, height: 2 },
  },
  backBtn: {
    width: 40,
    height: 40,
    justifyContent: 'center',
    alignItems: 'center',
  },
  headerTitle: {
    flex: 1,
    textAlign: 'center',
    color: '#1A1D1E',
    fontSize: 18,
    fontFamily: 'Poppins-SemiBold',
  },
  content: {
    paddingBottom: 30,
    paddingHorizontal: 15,
    paddingTop: 15,
  },
  loaderContainer: {
    marginTop: 50,
    alignItems: 'center',
  },
  loaderText: {
    marginTop: 10,
    color: '#666',
    fontFamily: 'Poppins-Regular',
  },
  notificationCard: {
    backgroundColor: '#fff',
    padding: 15,
    borderRadius: 15,
    marginBottom: 15,
    shadowColor: '#00BDD6',
    shadowOpacity: 0.1,
    shadowRadius: 10,
    elevation: 3,
    borderLeftWidth: 4,
    borderLeftColor: '#00BDD6',
  },
  cardHeader: {
    flexDirection: 'row',
    alignItems: 'center',
    marginBottom: 8,
  },
  iconCircle: {
    width: 32,
    height: 32,
    borderRadius: 16,
    backgroundColor: '#EFF6FF',
    justifyContent: 'center',
    alignItems: 'center',
    marginRight: 10,
  },
  notificationTitle: {
    fontSize: 15,
    color: '#1A1D1E',
    fontFamily: 'Poppins-SemiBold',
    flex: 1,
  },
  notificationDescription: {
    fontSize: 13,
    color: '#444',
    fontFamily: 'Poppins-Regular',
    lineHeight: 20,
    marginLeft: 42,
  },
  notificationTime: {
    fontSize: 11,
    color: '#999',
    textAlign: 'right',
    marginTop: 10,
    fontFamily: 'Poppins-Medium',
  },
  emptyContainer: {
    marginTop: 100,
    alignItems: 'center',
  },
  emptyText: {
    marginTop: 15,
    fontSize: 16,
    color: '#999',
    fontFamily: 'Poppins-Medium',
  },
});
