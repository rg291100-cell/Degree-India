import React, { useEffect, useState } from 'react';
import {
  View,
  Text,
  StatusBar,
  StyleSheet,
  TouchableOpacity,
  ActivityIndicator,
} from 'react-native';
import Icon from 'react-native-vector-icons/Ionicons';
import {
  widthPercentageToDP as wp,
  heightPercentageToDP as hp,
} from 'react-native-responsive-screen';
import { RFPercentage } from 'react-native-responsive-fontsize';
import { SafeAreaView } from 'react-native-safe-area-context';
import { getApi } from '../config/api';

const AdmissionScreen = ({ navigation }) => {
  const [admission, setAdmission] = useState(null);
  const [loading, setLoading] = useState(false);
  const [expanded, setExpanded] = useState(false); // Hide details by default

  const getMyAdmissions = async () => {
    try {
      setLoading(true);
      const res = await getApi('/admissions/my-admissions', true);
      console.log('My Admissions Data:', res);
      // ✅ FIX: Backend returns 'admissions' key, not 'data'
      const data = res?.admissions?.[0] || null;
      setAdmission(data);
    } catch (error) {
      console.log('Error fetching admissions:', error);
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    getMyAdmissions();
  }, []);

  if (loading) {
    return (
      <View style={styles.center}>
        <ActivityIndicator size="large" color="#2D6EFF" />
      </View>
    );
  }

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

      <View style={styles.cardWrapper}>
        <View style={styles.topBox} />

        <View style={styles.detailsWrapper}>

          {!admission ? (
            <Text style={{ textAlign: 'center', marginTop: 20 }}>No Admission Found</Text>
          ) : (
            <>
              <View style={styles.row}>
                <View style={styles.item}>
                  <Icon name="document-text-outline" size={20} color="#000" />
                  <View>
                    <Text style={styles.label}>Enrolment No.</Text>
                    <Text style={styles.value}>{admission.enrollment_no || 'N/A'}</Text>
                  </View>
                </View>

                <View style={styles.item}>
                  <Icon name="cash-outline" size={20} color="#000" />
                  <View>
                    <Text style={styles.label}>Total Fees</Text>
                    <Text style={styles.value}>{admission.total_fees || '0'}</Text>
                  </View>
                </View>
              </View>

              {expanded && (
                <>
                  {/* Row 2 */}
                  <View style={styles.row}>
                    <View style={styles.item}>
                      <Icon name="school-outline" size={20} color="#000" />
                      <View>
                        <Text style={styles.label}>College / University</Text>
                        <Text style={styles.value}>{admission.university_name || admission.college_name || 'N/A'}</Text>
                      </View>
                    </View>

                    <View style={styles.item}>
                      <Icon name="card-outline" size={20} color="#000" />
                      <View>
                        <Text style={styles.label}>Paid Fees</Text>
                        <Text style={styles.value}>{admission.paid_fees || '0'}</Text>
                      </View>
                    </View>
                  </View>

                  {/* Row 3 */}
                  <View style={styles.row}>
                    <View style={styles.item}>
                      <Icon name="time-outline" size={20} color="#000" />
                      <View>
                        <Text style={styles.label}>Course Type</Text>
                        <Text style={styles.value}>{admission.course_type || 'Full Time'}</Text>
                      </View>
                    </View>

                    <View style={styles.item}>
                      <Icon name="book-outline" size={20} color="#000" />
                      <View>
                        <Text style={styles.label}>Medium</Text>
                        <Text style={styles.value}>{admission.medium || 'English'}</Text>
                      </View>
                    </View>
                  </View>
                </>
              )}
            </>
          )}

        </View>

        {/* Bottom arrow - Toggle details */}
        {admission && (
          <TouchableOpacity
            style={styles.bottomArrow}
            onPress={() => setExpanded(!expanded)}
          >
            <Icon
              name={expanded ? "chevron-up-outline" : "chevron-down-outline"}
              size={30}
              color="black"
            />
          </TouchableOpacity>
        )}
      </View>
    </SafeAreaView>
  );
};

export default AdmissionScreen;

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#fff',
  },
  center: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center'
  },
  header: {
    flexDirection: 'row',
    alignItems: 'center',
    padding: 15,
    gap: 50,
    marginTop: hp('0.9%'),
  },
  backBtn: {
    width: wp('10%'),
    height: wp('10%'),
    backgroundColor: '#2D6EFF',
    borderRadius: wp('10%'),
    justifyContent: 'center',
    alignItems: 'center',
  },
  headerTitle: {
    fontSize: RFPercentage(2.5),
    fontWeight: '600',
    fontFamily: 'Poppins-SemiBold',
  },
  cardWrapper: {
    width: wp('90%'),
    alignSelf: 'center',
    borderWidth: 1,
    borderColor: '#ccc',
    borderRadius: wp('3%'),
    marginTop: hp('4%'),
    backgroundColor: '#fff',
    paddingBottom: hp('2%'),
  },
  topBox: {
    height: hp('20%'),
    borderTopLeftRadius: wp('3%'),
    borderTopRightRadius: wp('3%'),
    backgroundColor: '#f0f0f0' // added visible bg
  },
  detailsWrapper: {
    paddingHorizontal: wp('4%'),
    paddingTop: hp('1%'),
  },
  row: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: 10,
    marginTop: hp('2%'),
    justifyContent: 'space-between',
    paddingVertical: hp('2%'),
    borderBottomColor: '#eaeaea',
    borderBottomWidth: 1,
  },
  item: {
    width: wp('40%'),
    flexDirection: 'row',
    alignItems: 'center',
    gap: 10,
  },
  label: {
    fontSize: RFPercentage(1.6),
    color: '#444',
    fontFamily: 'Poppins-Regular',
  },
  value: {
    fontSize: RFPercentage(2),
    fontWeight: '600',
    fontFamily: 'Poppins-Regular',
    flexWrap: 'wrap',
    maxWidth: wp('30%')
  },
  bottomArrow: {
    alignSelf: 'center',
    marginTop: hp('2%'),
  },
});
