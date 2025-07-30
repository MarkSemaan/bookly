import React, { useState, useRef, useEffect } from 'react';
import { useNavigate } from "react-router-dom"; 
import Lottie from "lottie-react";
import BookLogo from "../../../Assets/Animations/BookLogo.json";
import ThemeToggle from "./ThemeToggle"; 
import "./navbar.css";

const Navbar = () => {
  const [showDropdown, setShowDropdown] = useState(false);
  const dropdownRef = useRef();
  const navigate = useNavigate();

  const handleLogout = () => {
   localStorage.removeItem("token");
   navigate("/login");
  };

  const toggleDropdown = () => {
    setShowDropdown((prev) => !prev);
  };

  useEffect(() => {
    const handleClickOutside = (event) => {
      if (dropdownRef.current && !dropdownRef.current.contains(event.target)) {
        setShowDropdown(false);
      }
    };

    document.addEventListener("mousedown", handleClickOutside);
    return () => {
      document.removeEventListener("mousedown", handleClickOutside);
    };
  }, []);

  return (
    <nav className='Navbar'>
      <div className='Navbar-logo'>
        <Lottie 
          animationData={BookLogo} loop={true} className='Navbar-animation'
        />
        <div className='title'>
          <h2>Bookly</h2>
        </div>
      </div>

      <div className="right-section">
        <ThemeToggle />
        <div className="Navbar-profile" onClick={toggleDropdown} ref={dropdownRef}>
          <img
            src="https://static.vecteezy.com/system/resources/previews/027/448/973/large_2x/avatar-account-icon-default-social-media-profile-photo-vector.jpg"
            alt="Profile"
            className="pro-pic"
          />
          {showDropdown && (
            <ul className="dropdown">
              <li><a onClick={handleLogout}>Logout</a></li>
            </ul>
          )}
        </div>
      </div>
    </nav>
  );
};

export default Navbar;
