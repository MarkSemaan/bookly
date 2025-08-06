 
import "./mediaUpload.css";
import camera from "../../Assets/Icons/camera.svg";
import useImageUpload from "../../Hooks/useImageUpload";

const MediaUpload = ({ setImageBase64 }) => {
  const {
    imageInputRef,
    selectedFileName,
    openImagePicker,
    handleImageChange,
  } = useImageUpload(setImageBase64);

  return (
    <div className="media-upload-container">
      <div className="media-upload-box">
        <button
          type="button"
          onClick={openImagePicker}
          className="media-upload-icon-button"
        >
          <img src={camera} alt="Camera Icon" />
        </button>

        {selectedFileName && (
          <div className="selected-file-name">{selectedFileName}</div>
        )}

        <input
          type="file"
          accept="image/*"
          ref={imageInputRef}
          style={{ display: "none" }}
          onChange={handleImageChange}
        />
      </div>
    </div>
  );
};

export default MediaUpload;
