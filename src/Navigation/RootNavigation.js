import React from 'react';
import { createNativeStackNavigator } from '@react-navigation/native-stack';
import { NavigationContainer } from '@react-navigation/native';
import TabNavigation from '../Navigation/TabNavigation';
import Admission from '../screens/Admission';
import Course from '../screens/Course';
import Animation from '../screens/Animation';
import DAnimation from '../screens/DAnimation';
import Educational from '../screens/Educational';
import ExpertTips from '../screens/ExpertTips';
import Educationalpartners from '../screens/Educationalpartners';
import RML from '../screens/RML';
import BookYour from '../screens/BookYour';
import Career from '../screens/Career';
import Name from '../screens/Name';
import EmailId from '../screens/EmailId';
import Mobile from '../screens/Mobile';
import Location from '../screens/Location';
import Login from '../screens/Login';
import Splash from '../screens/Splash';
import Profile from '../screens/Profile';
import Notification from '../screens/Notification';
import CourseDetails from '../screens/CourseDetails';


const Stack = createNativeStackNavigator();

const RootNavigation = () => {
  return (
    <NavigationContainer>
      <Stack.Navigator>
          <Stack.Screen
          name="Splash"
          component={Splash}
          options={{ headerShown: false }}
        />

           <Stack.Screen
          name="Login"
          component={Login}
          options={{ headerShown: false }}
        />
      
        <Stack.Screen
          name="Name"
          component={Name}
          options={{ headerShown: false }}
        />
        <Stack.Screen
          name="EmailId"
          component={EmailId}
          options={{ headerShown: false }}
        />
        <Stack.Screen
          name="Mobile"
          component={Mobile}
          options={{ headerShown: false }}
        />
        <Stack.Screen
          name="Location"
          component={Location}
          options={{ headerShown: false }}
        />
     
        <Stack.Screen
          name="TabNavigation"
          component={TabNavigation}
          options={{ headerShown: false }}
        />
        <Stack.Screen
          name="Admission"
          component={Admission}
          options={{ headerShown: false }}
        />

  <Stack.Screen
          name="Notification"
          component={Notification}
          options={{ headerShown: false }}
        />
          <Stack.Screen
          name="CourseDetails"
          component={CourseDetails}
          options={{ headerShown: false }}
        />


        
        <Stack.Screen
          name="Course"
          component={Course}
          options={{ headerShown: false }}
        />
        <Stack.Screen
          name="Animation"
          component={Animation}
          options={{ headerShown: false }}
        />
     <Stack.Screen
          name="Profile"
          component={Profile}
          options={{ headerShown: false }}
        />
        <Stack.Screen
          name="DAnimation"
          component={DAnimation}
          options={{ headerShown: false }}
        />
        <Stack.Screen
          name="Educational"
          component={Educational}
          options={{ headerShown: false }}
        />
        <Stack.Screen
          name="ExpertTips"
          component={ExpertTips}
          options={{ headerShown: false }}
        />
        <Stack.Screen
          name="Educationalpartners"
          component={Educationalpartners}
          options={{ headerShown: false }}
        />
        <Stack.Screen
          name="RML"
          component={RML}
          options={{ headerShown: false }}
        />
        <Stack.Screen
          name="BookYour"
          component={BookYour}
          options={{ headerShown: false }}
        />
        <Stack.Screen
          name="Career"
          component={Career}
          options={{ headerShown: false }}
        />
      </Stack.Navigator>
    </NavigationContainer>
  );
};

export default RootNavigation;
