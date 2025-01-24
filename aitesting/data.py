# Import libraries
import numpy as np
import pandas as pd
from sklearn.model_selection import train_test_split
from sklearn.preprocessing import StandardScaler
import tensorflow as tf
from tensorflow.keras.models import Sequential
from tensorflow.keras.layers import Dense

# Step 1: Load and prepare the dataset
# Replace with your dataset
data = pd.read_csv('test.csv')  # Example: A CSV file with features and a target column
X = data[['age', 'income', 'spending_score']].values  # Replace with actual feature column names
y = data['purchased'].values  # Replace with the target column name

# Step 2: Split the data
X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.2, random_state=42)

# Step 3: Normalize the data
scaler = StandardScaler()
X_train = scaler.fit_transform(X_train)
X_test = scaler.transform(X_test)
print("Shape of X:", X.shape)  # (6, 3)
print("Shape of y:", y.shape)  # (6,)

# Step 4: Define the model
model = Sequential([
    Dense(32, activation='relu', input_shape=(X_train.shape[1],)),
    Dense(16, activation='relu'),
    Dense(1, activation='sigmoid')  # Use 'softmax' for multi-class classification
])

# Step 5: Compile the model
model.compile(optimizer='adam', loss='binary_crossentropy', metrics=['accuracy'])

# Step 6: Train the model
print("Training the model...")
history = model.fit(X_train, y_train, validation_data=(X_test, y_test), epochs=20, batch_size=32)

# Step 7: Evaluate the model
loss, accuracy = model.evaluate(X_test, y_test)
print(f"Test Accuracy: {accuracy:.2f}")

# Generate predictions
subset_X_test = X_test[:10]
predictions = model.predict(X_test)

# Print the rows corresponding to the predictions
print("Sample predictions with corresponding rows:")

# Iterate over the first few predictions and display them with their corresponding rows
for i in range(min(10, len(predictions))):  # Adjust to show up to 5 predictions
    print(f"Row {X_test[i]}: Prediction: {predictions[i]}")


# Step 9: Save the model
model.save('my_model.h5')
print("Model saved as 'my_model.h5'")
