import numpy as np
import pandas as pd
from sklearn import preprocessing
from sklearn.model_selection import train_test_split
from sklearn.naive_bayes import GaussianNB
from sklearn.metrics import confusion_matrix, classification_report

data = pd.read_excel('credit.xlsx')
x = data.iloc[:, 0:4]
y = data.iloc[:, 4]

# print("Features:\n", x)
# print("Info \n", data.info())

x_train, x_test, y_train, y_test = train_test_split(
    x, y, test_size=0.2, random_state=123    
)
# print("Spliting: \n",[
#     x_train,
#     x_test
# ])

model = GaussianNB()
nb_model = model.fit(x_train, y_train)
y_pred = nb_model.predict(x_test)

print("Class Count: \n", nb_model.class_count_)
print("Hasil Prediksi: \n", y_pred)