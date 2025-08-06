 
import "./input.css";

const FormInput = ({ type, name, hint, required, onChangeListener }) => {
  return (
      <input
        type={type}
        name={name}
        placeholder={hint}
        className="input-wrapperr input"
        required={required}
        onChange={onChangeListener}
      />
  );
};

export default FormInput;
