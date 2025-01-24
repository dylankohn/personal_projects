import zipfile
import pandas as pd
import streamlit as st
from io import BytesIO

# Path to your zip file
zip_file_path = st.file_uploader("Upload a zip file", type="zip")

# Open the zip file
with zipfile.ZipFile(zip_file_path, 'r') as zip_ref:
    # List all files in the zip
    all_files = zip_ref.namelist()
    
    # Iterate through each file in the zip
    for file in all_files:
        # Check if the file is an Excel file
        if file.endswith(('.xlsx', '.xls')):
            print(f"Processing: {file}")
            
            # Extract the file's data into memory
            with zip_ref.open(file) as excel_file:
                # Read the Excel file using pandas
                df = pd.read_excel(excel_file)
                
                # Display the first few rows of the dataframe
                print(df.to_string(index=False))  # Remove `index=False` if you want to include the index
                print("\n" + "="*80 + "\n")
