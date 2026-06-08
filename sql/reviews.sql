CREATE TABLE reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sentence TEXT,
    rating VARCHAR(50),
    comment TEXT,
    ai_score INT,
    ai_feedback TEXT,
    ai_corrected TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);