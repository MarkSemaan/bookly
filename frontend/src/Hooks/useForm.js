import { useState } from "react";

const useForm = (initialValues = {}) => {
  const [form, setForm] = useState(initialValues);

  const handleRegister = (e) => {
    const { name, value } = e.target;
    setForm((prev) => ({ ...prev, [name]: value }));
  };

  return [form, handleRegister];
};

export default useForm;