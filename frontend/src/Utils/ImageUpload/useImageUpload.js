import { useRef, useState } from "react";

const useImageUpload = (setImageBase64) => {
  const imageInputRef = useRef(null);
  const [selectedFileName, setSelectedFileName] = useState("");

  const openImagePicker = () => {
    if (imageInputRef.current) imageInputRef.current.click();
  };

  const handleImageChange = (e) => {
    const file = e.target.files[0];
    if (file) {
      setSelectedFileName(file.name);
      const reader = new FileReader();
      reader.onloadend = () => {
        setImageBase64(reader.result);
      };
      reader.readAsDataURL(file);
    }
  };

  return {
    imageInputRef,
    selectedFileName,
    openImagePicker,
    handleImageChange,
  };
};

export default useImageUpload;
