import React from "react";
import {
  View,
  Text,
  TouchableOpacity,
  Modal,
  StyleSheet,
  FlatList,
} from "react-native";
import Icon from "react-native-vector-icons/MaterialIcons";

const CustomPicker = ({
  visible,
  onClose,
  title,
  data,
  selectedValue,
  onSelect,
}) => {
  return (
    <Modal visible={visible} transparent animationType="slide">
      <View style={styles.modalContainer}>
        <View style={styles.modalBox}>
          <Text style={styles.title}>{title}</Text>

          <FlatList
            data={data}
            keyExtractor={(item) => item}
            renderItem={({ item }) => (
              <TouchableOpacity
                style={[
                  styles.option,
                  selectedValue === item && styles.selectedOption,
                ]}
                onPress={() => {
                  onSelect(item);
                  onClose();
                }}
              >
                <Text style={styles.optionText}>{item}</Text>
                {selectedValue === item && (
                  <Icon name="check" size={22} color="#000" />
                )}
              </TouchableOpacity>
            )}
          />

          <TouchableOpacity style={styles.closeBtn} onPress={onClose}>
            <Text style={styles.closeText}>Cancel</Text>
          </TouchableOpacity>
        </View>
      </View>
    </Modal>
  );
};

export default CustomPicker;

const styles = StyleSheet.create({
  modalContainer: {
    flex: 1,
    justifyContent: "flex-end",
    backgroundColor: "rgba(0,0,0,0.4)",
  },
  modalBox: {
    backgroundColor: "#fff",
    borderTopLeftRadius: 12,
    borderTopRightRadius: 12,
    padding: 20,
    maxHeight: "60%",
  },
  title: {
    fontSize: 18,
    marginBottom: 15,
    color: "#000",
    fontFamily: 'Poppins-SemiBold',
  },
  option: {
    paddingVertical: 12,
    flexDirection: "row",
    justifyContent: "space-between",
    borderBottomWidth: 0.4,
    borderColor: "#ccc",
  },
  selectedOption: {
    backgroundColor: "#f2f2f2",
  },
  optionText: {
    fontSize: 15,
    color: "#000",
        fontFamily: 'Poppins-Regular',

  },
  closeBtn: {
    marginTop: 10,
    paddingVertical: 12,
    alignItems: "center",
  },
  closeText: {
    fontSize: 16,
    // fontWeight: "600",
    color: "red",
        fontFamily: 'Poppins-SemiBold',

  },
});
