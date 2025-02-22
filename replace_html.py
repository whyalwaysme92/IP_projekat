import os

def replace_in_files(directory):
    for root, _, files in os.walk(directory):
        for file in files:
            if file.endswith(".php"):
                file_path = os.path.join(root, file)

                with open(file_path, "r", encoding="utf-8") as f:
                    content = f.read()

                if ".html" in content:
                    updated_content = content.replace(".html", ".php")

                    with open(file_path, "w", encoding="utf-8") as f:
                        f.write(updated_content)

                    print(f"Izmenjen fajl: {file_path}")

# Pokreće funkciju u trenutnom direktorijumu
replace_in_files(os.getcwd())
