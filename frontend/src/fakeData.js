
export const categories = [
  { id: 1, name: "Fiction", description: "Imaginary stories and novels" },
  { id: 2, name: "Horror", description: "Spooky and thrilling tales" },
  { id: 3, name: "Health & Fitness", description: "Tips for a healthy lifestyle" },
  { id: 4, name: "History", description: "Stories from the past" },
  { id: 5, name: "Cooking & Food", description: "Delicious recipes and food guides" },
];


export const books = [
  {
    id: 1,
    title: "The Great Gatsby",
    author: "F. Scott Fitzgerald",
    publisher: "Scribner",
    published_year: 1925,
    description: "A novel about the American dream.",
    price: 15.99,
    stock: 10,
    image: "https://picsum.photos/200/300?random=1",
    sold: 100,
    is_available: true,
    rating: 4,
    categories: [1],
  },
  {
    id: 2,
    title: "A Brief History of Time",
    author: "Stephen Hawking",
    publisher: "Bantam",
    published_year: 1988,
    description: "Explores cosmology and the universe.",
    price: 20.5,
    stock: 5,
    image: "https://picsum.photos/200/300?random=2",
    sold: 50,
    is_available: true,
    rating: 5,
    categories: [2],
  },
  // Add more books...
];

export const reviews = [
  {
    id: 1,
    user_id: 1,
    book_id: 1,
    comment: "Loved this book! A classic.",
    rating: 5,
  },
  {
    id: 2,
    user_id: 2,
    book_id: 2,
    comment: "Super interesting and deep!",
    rating: 4,
  },
  // Add more reviews...
];
