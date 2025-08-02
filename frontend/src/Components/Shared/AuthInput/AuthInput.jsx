import React from "react";
import "./authInput.css";

const Input = ({ type, name, hint, placeholder, required, onChangeListener }) => {
  return (
    <div className="input-group">
      <label className="auth-label" htmlFor={name}>
        {hint}
      </label>

      <input
        id={name}
        type={type}
        hint={hint}
        placeholder={placeholder}
        required={required}
        className="primary-input"
        onChange={onChangeListener}
      />

    </div>
  );
};

export default Input;
