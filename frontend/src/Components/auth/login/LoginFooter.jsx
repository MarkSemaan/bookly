import React from "react";
import { Link } from "react-router-dom";

const LoginFooter= () => {
  return (
    <div className="sign_up">
      <p>
        Don’t have an account?{" "}
        <Link to="/register" className="sign-up-link">
          Sign Up
        </Link>
      </p>
    </div>
  );
};

export default LoginFooter;
