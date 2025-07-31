import React from "react";
import { useTheme } from "../../../Context/ThemeContext";
import sunIcon from "../../../Assets/Icons/sun.svg";
import moonIcon from "../../../Assets/Icons/moon.svg";


const ThemeToggle = () => {
  const { theme, toggleTheme } = useTheme();

  const handleThemeToggle = () => {
    toggleTheme();
  };

  return (
    <div className="icon-toggle" onClick={handleThemeToggle}>
      {theme === "light" ? (
        <img src={sunIcon} alt="Light Mode" className="Navbar-icon" />
      ) : (
        <img src={moonIcon} alt="Dark Mode" className="Navbar-icon" />
      )}
    </div>
  );
};

export default ThemeToggle;
