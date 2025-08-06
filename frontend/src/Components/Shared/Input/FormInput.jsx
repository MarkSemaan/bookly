 
import "./input.css";

const FormInput = ({ type, name, hint,value, required, onChangeListener }) => {
  return (
      <input
        type={type}
        name={name}
        placeholder={hint}
        className="input-wrapperr input"
        required={required}
        value={value}
        onChange={onChangeListener}
      />
  );
};

export default FormInput;
