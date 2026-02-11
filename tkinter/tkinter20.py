import tkinter as tk
import sqlite3
from tkinter import messagebox
from tkinter import ttk
import subprocess


#Funktsioonid
def validate_data():
    enimi = entries["Eesnimi"].get()
    pnimi = entries["Perenimi"].get()
    email = entries["Email"].get()
    tel = entries["Telefon"].get()
    pilt = entries["Pilt"].get()

    if not enimi:
        tk.messagebox.showerror("Viga", "Pealkiri on kohustuslik!")
        return False
    if not pnimi:
        tk.messagebox.showerror("Viga", "Pealkiri on kohustuslik!")
        return False
    if not email:
        tk.messagebox.showerror("Viga", "Pealkiri on kohustuslik!")
        return False
    if not tel:
        tk.messagebox.showerror("Viga", "Pealkiri on kohustuslik!")
        return False
    if not pilt:
        tk.messagebox.showerror("Viga", "Pealkiri on kohustuslik!")
        return False

    #  tk.messagebox.showinfo("Edu", "Andmed on kehtivad!")
    return True

# valideerib andmed ja lisab need andmebaasi
def insert_data():
    if validate_data():
        connection = sqlite3.connect("jtoomingas.db")
        cursor = connection.cursor()

        cursor.execute("""
            INSERT INTO users (first_name, last_name, email, phone, image)
            VALUES (?, ?, ?, ?, ?)
        """, (
            entries["Eesnimi"].get(),
            entries["Perenimi"].get(),
            entries["Email"].get(),
            entries["Telefon"].get(),
            entries["Pilt"].get()
        ))

        connection.commit()
        connection.close()

        messagebox.showinfo("Edu", "Andmed sisestati edukalt!")


# Loo Tkinteri aken
root = tk.Tk()
root.title("Kasutajate lisamine")

# Loo sildid ja sisestusväljad
labels = ["Eesnimi", "Perenimi", "Email", "Telefon", "Pilt"]
entries = {}

for i, label in enumerate(labels):
    tk.Label(root, text=label).grid(row=i, column=0, padx=10, pady=5)
    entry = tk.Entry(root, width=40)
    entry.grid(row=i, column=1, padx=10, pady=5)
    entries[label] = entry

# Loo nupp andmete sisestamiseks
submit_button = tk.Button(root, text="Lisa Kasutaja", command=insert_data)
submit_button.grid(row=len(labels), column=0, columnspan=2, pady=20)

#Andmete kuvamine
def load_data_from_db(tree):
    # Loo ühendus SQLite andmebaasiga
    conn = sqlite3.connect('jtoomingas.db')
    cursor = conn.cursor()

    # Tee päring andmebaasist andmete toomiseks
    cursor.execute("SELECT first_name, last_name, email, phone, image FROM users")
    rows = cursor.fetchall()

    # Lisa andmed tabelisse
    for row in rows:
        tree.insert("", "end", values=row)

    # Sulge ühendus andmebaasiga
    conn.close()

root = tk.Tk()
root.title("Users")


# Loo raam kerimisribaga
frame = tk.Frame(root)
frame.pack(pady=20, fill=tk.BOTH, expand=True)
scrollbar = tk.Scrollbar(frame)
scrollbar.pack(side=tk.RIGHT, fill=tk.Y)

# Loo tabel (Treeview) andmete kuvamiseks
tree = ttk.Treeview(frame, yscrollcommand=scrollbar.set, columns=("first_name", "last_name", "email", "phone", "image"), show="headings")
tree.pack(fill=tk.BOTH, expand=True)

# Seosta kerimisriba tabeliga
scrollbar.config(command=tree.yview)

# Määra veergude pealkirjad ja laius
tree.heading("first_name", text="First names")
tree.heading("last_name", text="Last names")
tree.heading("email", text="Emails")
tree.heading("phone", text="Phones")
tree.heading("image", text="Images")


tree.column("first_name", width=150)
tree.column("last_name", width=100)
tree.column("email", width=60)
tree.column("phone", width=100)
tree.column("image", width=60)

def add_data():
    subprocess.run(["python", "tkinter19.py"])

open_button = tk.Button(root, text="Lisa andmeid", command=add_data)
open_button.pack(pady=20)

# Lisa andmed tabelisse
load_data_from_db(tree)

def on_search():
    search_query = search_entry.get()
    load_data_from_db(tree, search_query)





# Näita Tkinteri akent
root.mainloop()
