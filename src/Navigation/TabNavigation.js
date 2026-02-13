import React from 'react';
import { createBottomTabNavigator } from '@react-navigation/bottom-tabs';
import { Image, Linking, Alert } from 'react-native';
import { useRoute } from '@react-navigation/native';

// Screens
import Home from '../screens/Home';
import Menu from '../screens/Menu';
import Notification from '../screens/Notification';
import Offer from '../screens/offer';
import CustomTabButton from '../screens/CustomTabButton';

const BottomTab = createBottomTabNavigator();

// Dummy screen for Contact tab
const EmptyScreen = () => null;

const TabNavigation = () => {
  const route = useRoute();

 const openDialer = () => {
  const phoneNumber = 'tel:9867868768';
  Linking.openURL(phoneNumber).catch(err => {
    Alert.alert('Error', 'Unable to open dialer');
    console.error('Error opening dialer:', err);
  });
};

  return (
    <BottomTab.Navigator
      initialRouteName="Home" // 🔹 Make Home the default screen

      screenOptions={{
        headerShown: false,
        tabBarStyle: {
          backgroundColor: '#fff',
          height: 72,
          paddingBottom: 10,
          paddingTop: 5,
          position: 'absolute',
          elevation: 10,
        },
        tabBarLabelStyle: {
          fontSize: 10,
          marginBottom: 5,
          fontFamily: 'Poppins-Regular',
        },
      }}
    >
      {/* Offer */}
      <BottomTab.Screen
        name="Offer"
        component={Offer}
        options={{
          tabBarIcon: ({ focused }) => (
            <Image
              source={require('../assets/Image/offer.png')}
              style={{
                width: 25,
                height: 25,
                tintColor: focused ? '#03C5C1' : '#b3b3b3',
              }}
            />
          ),
        }}
      />

      {/* Contact → Dialer */}
     <BottomTab.Screen
  name="Contact"
  component={EmptyScreen}
  options={{
    tabBarIcon: ({ focused }) => (
      <Image
        source={require('../assets/Icons/phone.png')}
        style={{
          width: 25,
          height: 25,
          tintColor: focused ? '#03C5C1' : '#b3b3b3',
        }}
      />
    ),
  }}
  listeners={{
    tabPress: e => {
      e.preventDefault();
      openDialer();
    },
  }}
/>


      {/* Home (Center Button) */}
      <BottomTab.Screen
        name="Home"
        component={Home}
        options={{
          tabBarIcon: () => (
            <Image
              source={require('../assets/Image/home.png')}
              style={{ width: 25, height: 25, tintColor: '#fff' }}
            />
          ),
          tabBarButton: props => <CustomTabButton {...props} />,
        }}
      />

      {/* Offer */}
 

      {/* Notification */}
      <BottomTab.Screen
        name="Notification"
        component={Notification}
        options={{
          tabBarIcon: ({ focused }) => (
            <Image
              source={require('../assets/Image/notification.png')}
              style={{
                width: 25,
                height: 25,
                tintColor: focused ? '#03C5C1' : '#b3b3b3',
              }}
            />
          ),
        }}
      />

           <BottomTab.Screen
        name="Menu"
        component={Menu}
        options={{
          tabBarIcon: ({ focused }) => (
            <Image
              source={require('../assets/Image/hamburger.png')}
              style={{
                width: 25,
                height: 25,
                tintColor: focused ? '#03C5C1' : '#b3b3b3',
              }}
            />
          ),
        }}
      />
    </BottomTab.Navigator>
  );
};

export default TabNavigation;
