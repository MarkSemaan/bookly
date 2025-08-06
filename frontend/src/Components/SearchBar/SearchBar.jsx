import './searchBar.css';
import { IoIosSearch } from "react-icons/io";

const SearchBox = ({ placeholder, onChangeHandler }) => {
    
  return (
    <div className="search-wrapper">
      <input
        type="search"
        className="searchbox"
        placeholder={placeholder}
        onChange={onChangeHandler}
      />
      <IoIosSearch className="search-icon" />
    </div>
  );
};

export default SearchBox;
