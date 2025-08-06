import React from "react";
import "./authInput.css";

const Input = ({ type = "text", name, hint, placeholder, required, value, onChangeListener }) => {
  return (
    <div className="input-group">
      <label className="auth-label" htmlFor={name}>
        {hint}
      </label>

      <input
        id={name}
        type={type}
        name={name}
        placeholder={placeholder}
        required={required}
        className="primary-input"
        value={value} 
        onChange={onChangeListener}
      />
    </div>
  );
};

export default Input;
