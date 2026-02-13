import React from 'react';
import { TouchableOpacity, View, Image, StyleSheet } from 'react-native';

const CustomTabButton = ({ children, onPress }) => {
  return (
    <TouchableOpacity style={styles.button} onPress={onPress}>
      <View style={styles.circle}>
        {children}
      </View>
    </TouchableOpacity>
  );
};

const styles = StyleSheet.create({
  button: {
    top: -25,
    justifyContent: 'center',
    alignItems: 'center',
  },
  circle: {
    width: 65,
    height: 65,
    borderRadius: 50,
    backgroundColor: '#03C5C1',
    justifyContent: 'center',
    alignItems: 'center',
    elevation: 10,
  },
});

export default CustomTabButton;
