
import useCategories from "../../../Hooks/Categories/useCategories";
import "./category.css";
const Category = ({ onCategoryClick }) => {
  const { categories, loading, error } = useCategories();

  if (loading) return <p>Loading...</p>;
  if (error) return <p>{error}</p>;

  return (
    <section className="category-section">
      {error && <p style={{ color: "red" }}>{error}</p>}
      {loading && <p>Loading categories...</p>}
      <h2 className="category-title">Categories</h2>
      <div className="category-cards">
        {categories.map((cat) => (
          <div
            className="category-card"
            key={cat.id}
            onClick={() => onCategoryClick({ id: cat.id, name: cat.name })} 
          >
            <h3 className="category-name">{cat.name}</h3>
            <p className="category-description">{cat.description}</p>
          </div>
        ))}
      </div>
    </section>
  );
};


export default Category;