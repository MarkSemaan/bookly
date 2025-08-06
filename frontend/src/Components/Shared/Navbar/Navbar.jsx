import { useState, useRef, useEffect } from 'react';
import {useTheme} from "../../../Context/ThemeContext";
import { useNavigate } from "react-router-dom"; 
import Lottie from "lottie-react";
import BookLogo from "../../../Assets/Animations/BookLogo.json";
import Notification from "../../../Assets/Icons/notfication.svg";
import checkout from "../../../Assets/Icons/checkout.svg";
import ThemeToggle from "../../themeToggle/ThemeToggle"; 
import  emptypfp from "../../../Assets/Icons/emptypfp.png";
import  emptypfpnight from "../../../Assets/Icons/emptypfpnight.png" ;  
import useAuth from "../../../Hooks/useAuth";
import "./navbar.css";

const Navbar = () => {

const { theme } = useTheme();

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
      <div className='Navbar-logo' onClick={() => navigate("/")} > 
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
              src={theme === 'dark' ? emptypfpnight : emptypfp}
              alt="Profile"
              className="pro-pic"
            />

            {showDropdown && (
              <ul className="dropdown">
                <li>
                  <button className="dropdown-logout-btn" onClick={handleLogout}>Logout</button>
                </li>
              </ul>
            )}
          </div>
        )}
      </div>
    </nav>
  );
};

export default Navbar;
