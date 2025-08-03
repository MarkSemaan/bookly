import React, { useState, useRef, useEffect } from 'react';
import { useNavigate } from "react-router-dom"; 
import Lottie from "lottie-react";
import BookLogo from "../../../Assets/Animations/BookLogo.json";
import Notification from "../../../Assets/Icons/notfication.svg";
import checkout from "../../../Assets/Icons/checkout.svg";
import ThemeToggle from "../../themeToggle/ThemeToggle"; 
import useAuth from "../../../Hooks/useAuth";
import "./navbar.css";

const Navbar = () => {
  const { isAuthenticated, logout } = useAuth();
  const [showDropdown, setShowDropdown] = useState(false);
  const dropdownRef = useRef();
  const navigate = useNavigate();

  const toggleDropdown = () => {
    setShowDropdown((prev) => !prev);
  };

  const handleLogout = () => {
    logout();
    navigate("/login");
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
        <Lottie animationData={BookLogo} loop={true} className='Navbar-animation' />
        <div className='title'><h2>Bookly</h2></div>
      </div>

      {isAuthenticated && (
        <div className="navbar-links">
          <a href="/bookList" className="btn nav-btn">Library</a>
          <a href="/myOrders" className="btn nav-btn">My Orders</a>
          <a href="/management" className="btn nav-btn">Management</a>
          <a href="/analytics" className="btn nav-btn">Analytics</a>
        </div>
      )}

      <div className='left'>
        {!isAuthenticated && (
          <>
            <a href="/login" className="btn nav-btn login-btn">Login</a>
            <a href="/register" className="btn nav-btn register-btn">Register</a>
          </>
        )}

        {isAuthenticated && (
          <>
            <a href="/cart" className="icon-btn">
              <img src={checkout} alt="Cart" />
            </a>
            <a href="/notifications" className="icon-btn">
              <img src={Notification} alt="Notifications" />
            </a>
          </>
        )}

        <ThemeToggle />

        {isAuthenticated && (
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
        )}
      </div>
    </nav>
  );
};

export default Navbar;
