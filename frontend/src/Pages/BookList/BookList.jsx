import React from "react";
import Category from "../../Components/bookPage/category/Catrgory";
import Bestsellers from "../../Components/bookPage/allBooks/bestSeller/BestSeller";
import Books from "../../Components/bookPage/allBooks/booklist/Books";




const BookList = () => {
  return (
    <>
      <Category />
       <Bestsellers />
       <Books />
    </>
  );
};

export default BookList;
