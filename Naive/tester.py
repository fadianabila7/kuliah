import pandas as pd
from sklearn.model_selection import train_test_split
from sklearn.pipeline import Pipeline
from sklearn.compose import ColumnTransformer
from jcopml.pipeline import num_pipe, cat_pipe
from jcopml.plot import plot_confusion_matrix


data = pd.read_csv('D:\\kuliah\\Naive\\data.csv');

data_awal = data.drop(columns="Play")
data_label = data.Play

data_awal_train, data_awal_test,data_label_train, data_label_test = train_test_split(
    data_awal, 
    data_label,
    test_size=0.2,
    random_state=42)

print("Spliting: ",[
    data_awal_train.shape,
    data_awal_test.shape,
    data_label_train.shape,
    data_label_test.shape
])

preprocessor = ColumnTransformer([
    ('categoric', cat_pipe(encoder="onehot"),["Outlook","Temperature","Humidity","Windy"])
])

# print(preprocessor)

from sklearn import pipeline
from sklearn.naive_bayes import GaussianNB

pipeline = Pipeline([
    ('prep', preprocessor),
    ('algo', GaussianNB())
])

pipeline.fit(data_awal_train, data_label_train)

print("\nTraining Data:")
print(data_awal_train.head())
print("\nTest Data:")
print(data_awal_test.head())

print("\nPerforma traning: ", pipeline.score(data_awal_train, data_label_train))
print("Performa test: ", pipeline.score(data_awal_test, data_label_test))

# evaluasi model
plot_confusion_matrix(data_awal_train, data_label_train, data_awal_test, data_label_test, pipeline)
import matplotlib.pyplot as plt
plt.show()  # Add this to display the confusion matrix plot