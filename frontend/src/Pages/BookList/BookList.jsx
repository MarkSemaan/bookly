import { useState } from "react";
import Category from "../../Components/bookPage/category/Catrgory";
import Bestsellers from "../../Components/bookPage/allBooks/bestSeller/BestSeller";
import Books from "../../Components/bookPage/allBooks/booklist/Books";
import RecommendedBooks from "../../Components/ai/ai";




const BookList = () => {
  const [selectedCategory, setSelectedCategory] = useState(null);

  return (
    <>
      <Category onCategoryClick={setSelectedCategory} />
      <RecommendedBooks/>
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
