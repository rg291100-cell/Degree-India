import React, { useEffect, useState } from 'react';
import {
  View,
  Text,
  StatusBar,
  StyleSheet,
  TouchableOpacity,
  ActivityIndicator,
  ScrollView,
} from 'react-native';
import Icon from 'react-native-vector-icons/Ionicons';
import {
  widthPercentageToDP as wp,
  heightPercentageToDP as hp,
} from 'react-native-responsive-screen';
import { RFPercentage } from 'react-native-responsive-fontsize';
import { SafeAreaView } from 'react-native-safe-area-context';
import { getApi } from '../config/api';

import AsyncStorage from '@react-native-async-storage/async-storage';

// Separate component or inline render to handle individual expansion state
const AdmissionItem = ({ item }) => {
  const [expanded, setExpanded] = useState(false);

  const formatDate = (dateString) => {
    if (!dateString) return 'N/A';
    return new Date(dateString).toLocaleDateString();
  };

  return (
    <View style={styles.listItem}>

      {/* Header Info */}
      <View style={styles.listHeader}>
        <Text style={styles.courseTitle}>{item.course?.title || 'Unknown Course'}</Text>
        <Text style={styles.collegeName}>{item.college_name || 'N/A'}</Text>
        <Text style={styles.admissionDate}>Admission Date: {formatDate(item.admission_date)}</Text>
      </View>

      <View style={styles.divider} />

      {/* Fees Section - Always Visible */}
      <View style={styles.rowSpecs}>
        <View style={styles.specItem}>
          <Text style={styles.label}>Total Fees</Text>
          <Text style={styles.valueHighlight}>₹{item.total_fees || '0'}</Text>
        </View>
        <View style={styles.specItem}>
          <Text style={styles.label}>Paid Fees</Text>
          <Text style={styles.valueHighlight}>₹{item.paid_fees || '0'}</Text>
        </View>
      </View>

      {/* Expandable Details Section */}
      {expanded && (
        <>
          <View style={styles.divider} />
          <View style={styles.detailsGrid}>

            <View style={styles.gridItem}>
              <Text style={styles.label}>Type</Text>
              <Text style={styles.value}>{item.course?.course_type || 'N/A'}</Text>
            </View>

            <View style={styles.gridItem}>
              <Text style={styles.label}>Mode</Text>
              <Text style={styles.value}>{item.course?.course_mode || 'N/A'}</Text>
            </View>

            <View style={styles.gridItem}>
              <Text style={styles.label}>Duration</Text>
              <Text style={styles.value}>
                {item.course?.duration} {item.course?.duration_unit}
              </Text>
            </View>

            <View style={styles.gridItem}>
              <Text style={styles.label}>Format</Text>
              <Text style={styles.value}>{item.course?.learning_format || 'N/A'}</Text>
            </View>

            <View style={styles.gridItem}>
              <Text style={styles.label}>Session</Text>
              <Text style={styles.value}>{item.course?.total_sessions || 'N/A'}</Text>
            </View>

          </View>
        </>
      )}

      {/* Toggle Arrow */}
      <TouchableOpacity
        style={styles.arrowContainer}
        onPress={() => setExpanded(!expanded)}
      >
        <Icon
          name={expanded ? "chevron-up-outline" : "chevron-down-outline"}
          size={24}
          color="#888"
        />
      </TouchableOpacity>

    </View>
  );
};

const AdmissionScreen = ({ navigation }) => {
  const [admissions, setAdmissions] = useState([]);
  const [loading, setLoading] = useState(false);

  const getMyAdmissions = async () => {
    try {
      setLoading(true);
      const token = await AsyncStorage.getItem('AUTH_TOKEN');
      console.log('User Token:', token);

      const res = await getApi('/admissions/my-admissions', true);

      if (res?.admissions) {
        setAdmissions(res.admissions);
      }
    } catch (error) {
      console.log('Error fetching admissions:', error);
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    getMyAdmissions();
  }, []);

  return (
    <SafeAreaView style={styles.container}>
      <StatusBar backgroundColor="#fff" barStyle="dark-content" />

      {/* ---------- Header ---------- */}
      <View style={styles.header}>
        <TouchableOpacity
          style={styles.backBtn}
          onPress={() => navigation.goBack()}
        >
          <Icon name="arrow-back" size={24} color="#fff" />
        </TouchableOpacity>

        <Text style={styles.headerTitle}>My Admission Desk</Text>
      </View>

      <ScrollView contentContainerStyle={{ paddingBottom: 20 }}>
        {loading ? (
          <View style={styles.center}>
            <ActivityIndicator size="large" color="#2D6EFF" />
          </View>
        ) : admissions.length > 0 ? (
          admissions.map((item, index) => (
            <AdmissionItem key={index} item={item} />
          ))
        ) : (
          <View style={styles.center}>
            <Text style={{ textAlign: 'center', marginTop: 20, fontSize: 16 }}>No Admission Found</Text>
          </View>
        )}
      </ScrollView>
    </SafeAreaView>
  );
};

export default AdmissionScreen;

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#f5f5f5', // Slightly darker bg for contrast
  },
  center: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
    marginTop: 50
  },
  header: {
    flexDirection: 'row',
    alignItems: 'center',
    padding: 15,
    backgroundColor: '#fff',
    elevation: 2,
    marginBottom: 10
  },
  backBtn: {
    width: 40,
    height: 40,
    backgroundColor: '#2D6EFF',
    borderRadius: 20,
    justifyContent: 'center',
    alignItems: 'center',
    marginRight: 15
  },
  headerTitle: {
    fontSize: RFPercentage(2.5),
    fontWeight: '600',
    fontFamily: 'Poppins-SemiBold',
    color: '#000'
  },
  listItem: {
    width: wp('92%'),
    alignSelf: 'center',
    backgroundColor: '#EEF2FF',
    borderRadius: 12,
    marginTop: 15,
    padding: 15,
    elevation: 3,
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 2 },
    shadowOpacity: 0.1,
    shadowRadius: 4,
  },
  arrowContainer: {
    alignItems: 'center',
    marginTop: 10,
    paddingTop: 5,
  },
  listHeader: {
    marginBottom: 5,
  },
  courseTitle: {
    fontSize: RFPercentage(2),
    fontFamily: 'Poppins-SemiBold',
    color: '#000',
    marginBottom: 2
  },
  collegeName: {
    fontSize: RFPercentage(1.6),
    fontFamily: 'Poppins-Regular',
    color: '#555',
  },
  admissionDate: {
    fontSize: RFPercentage(1.5),
    fontFamily: 'Poppins-Medium',
    color: '#888',
    marginTop: 2
  },
  divider: {
    height: 1,
    backgroundColor: '#f0f0f0',
    marginVertical: 12
  },
  rowSpecs: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    marginBottom: 5
  },
  specItem: {
    alignItems: 'flex-start',
  },
  valueHighlight: {
    fontSize: RFPercentage(2),
    fontFamily: 'Poppins-Bold',
    color: '#2D6EFF',
  },
  detailsGrid: {
    flexDirection: 'row',
    flexWrap: 'wrap',
    justifyContent: 'space-between',
    gap: 15
  },
  gridItem: {
    width: '30%',
    marginBottom: 10,
  },
  label: {
    fontSize: RFPercentage(1.4),
    color: '#999',
    fontFamily: 'Poppins-Regular',
  },
  value: {
    fontSize: RFPercentage(1.6),
    color: '#333',
    fontFamily: 'Poppins-Medium',
    marginTop: 2
  },
});
