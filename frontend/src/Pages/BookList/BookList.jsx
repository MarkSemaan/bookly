import { useState } from "react";
import Category from "../../Components/bookPage/category/Catrgory";
import Bestsellers from "../../Components/bookPage/allBooks/bestSeller/BestSeller";
import Books from "../../Components/bookPage/allBooks/booklist/Books";



const BookList = () => {
  const [selectedCategory, setSelectedCategory] = useState(null);

  return (
    <>
      <Category onCategoryClick={setSelectedCategory} />
      <Bestsellers />
      {selectedCategory && (
        <Books
          categoryId={selectedCategory.id}
          categoryName={selectedCategory.name}
        />
      )}
    </>
  );
};

export default BookList;
