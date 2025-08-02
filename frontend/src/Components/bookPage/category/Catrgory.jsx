import React from "react";
import { categories } from "../../../fakeData"; 
import useCategories from "../../../Hooks/useCategories";
import "./category.css";

const Category = () => {

    const { categories, loading, error } = useCategories();

    if (loading) return <p>Loading...</p>;
    if (error) return <p>{error}</p>;

  return (
    <section className="category-section">
      <h2 className="category-title">Categories</h2>
      <div className="category-cards">
        
      {categories.map(cat => (
        <div className="category-card" key={cat.id}>
          <h3 className="category-name">{cat.name}</h3>
          <p className="category-description">{cat.description}</p>
        </div>
      ))}
  
      </div>
    </section>
  );
  
};


export default Category;