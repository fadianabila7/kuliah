import pandas as pd
takaran = pd.read_csv('takaran_saji.csv')
# print(takaran.head())
# print(takaran.info()) 

data = takaran.drop('klasifikasi', axis=1)
label = takaran['klasifikasi']
# print("Data dan Label:")
# print(data.head())
# print("Label:")
# print(label.head())

from sklearn.model_selection import train_test_split
data_latih, data_uji, label_latih, label_uji = train_test_split(
    data,
    label,
    test_size=0.2)
# print("Data Latih:", data_latih.head())
# print("Label Latih:", label_latih.head())
# print("Data Uji:", data_uji.head())
# print("Label Uji:", label_uji.head())

from sklearn.preprocessing import StandardScaler
scaler = StandardScaler()
scaler.fit(data_latih)
data_latih = scaler.transform(data_latih)
data_uji = scaler.transform(data_uji)
# print("Data Latih setelah Standarisasi:")
# print(data_latih)
# print("Data Uji setelah Standarisasi:")
# print(data_uji)


from sklearn.neighbors import KNeighborsClassifier
model = KNeighborsClassifier(n_neighbors=2)
model.fit(data_latih, label_latih)
prediksi = model.predict(data_uji)
# print("Prediksi Kelas untuk Data Uji:")
# print(prediksi)

prediksi_probabiltas = model.predict_proba(data_uji)
# print("Probabilitas Prediksi untuk Data Uji:")  
# print(prediksi_probabiltas)

from sklearn.metrics import classification_report, confusion_matrix

print("Confusion Matrix:")
print(confusion_matrix(label_uji, prediksi))
print("Classification Report:")
print(classification_report(label_uji, prediksi))