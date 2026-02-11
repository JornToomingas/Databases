import tkinter as tk
import sqlite3
from tkinter import ttk, messagebox

root = tk.Tk()
root.title("Users")
root.geometry("900x500")

# ------------------ Andmete kuvamine ------------------
def load_data_from_db(tree, search_query=""):
    for item in tree.get_children():
        tree.delete(item)

    conn = sqlite3.connect('jtoomingas.db')
    cursor = conn.cursor()

    if search_query:
        cursor.execute("""
            SELECT first_name, last_name, email, phone, image 
            FROM users 
            WHERE first_name LIKE ? OR last_name LIKE ?
        """, ('%' + search_query + '%', '%' + search_query + '%'))
    else:
        cursor.execute("SELECT first_name, last_name, email, phone, image FROM users")

    rows = cursor.fetchall()
    for row in rows:
        tree.insert("", "end", values=row)

    conn.close()

# ------------------ Otsing ------------------
def on_search():
    search_query = search_entry.get()
    load_data_from_db(tree, search_query)

# ------------------ Lisa andmeid ------------------
def add_data():
    add_window = tk.Toplevel(root)
    add_window.title("Lisa kasutaja")
    add_window.geometry("400x300")

    labels = ["Eesnimi", "Perenimi", "Email", "Telefon", "Pilt"]
    entries = {}

    for i, label in enumerate(labels):
        tk.Label(add_window, text=label).grid(row=i, column=0, padx=10, pady=5)
        entry = tk.Entry(add_window, width=30)
        entry.grid(row=i, column=1, padx=10, pady=5)
        entries[label] = entry

    def save_user():
        enimi = entries["Eesnimi"].get()
        pnimi = entries["Perenimi"].get()
        email = entries["Email"].get()
        tel = entries["Telefon"].get()
        pilt = entries["Pilt"].get()

        if not enimi or not pnimi or not email or not tel or not pilt:
            messagebox.showerror("Viga", "Kõik väljad on kohustuslikud!")
            return

        conn = sqlite3.connect("jtoomingas.db")
        cursor = conn.cursor()
        cursor.execute("""
            INSERT INTO users (first_name, last_name, email, phone, image)
            VALUES (?, ?, ?, ?, ?)
        """, (enimi, pnimi, email, tel, pilt))
        conn.commit()
        conn.close()

        load_data_from_db(tree)
        add_window.destroy()

    tk.Button(add_window, text="Salvesta", command=save_user).grid(
        row=len(labels), column=0, columnspan=2, pady=20
    )

# ------------------ Ülemine otsingu + lisa nupp ------------------
top_frame = tk.Frame(root)
top_frame.pack(pady=10)

tk.Label(top_frame, text="Otsi nime järgi:").pack(side=tk.LEFT, padx=5)

search_entry = tk.Entry(top_frame)
search_entry.pack(side=tk.LEFT, padx=5)

tk.Button(top_frame, text="Otsi", command=on_search).pack(side=tk.LEFT, padx=5)
tk.Button(top_frame, text="Lisa kasutaja", command=add_data).pack(side=tk.LEFT, padx=20)

# ------------------ Tabeli osa ------------------
frame = tk.Frame(root)
frame.pack(fill=tk.BOTH, expand=True)

scrollbar_y = tk.Scrollbar(frame)
scrollbar_y.pack(side=tk.RIGHT, fill=tk.Y)

scrollbar_x = tk.Scrollbar(frame, orient=tk.HORIZONTAL)
scrollbar_x.pack(side=tk.BOTTOM, fill=tk.X)

tree = ttk.Treeview(
    frame,
    yscrollcommand=scrollbar_y.set,
    xscrollcommand=scrollbar_x.set,
    columns=("first_name", "last_name", "email", "phone", "image"),
    show="headings"
)
tree.pack(fill=tk.BOTH, expand=True)

scrollbar_y.config(command=tree.yview)
scrollbar_x.config(command=tree.xview)

tree.heading("first_name", text="First names")
tree.heading("last_name", text="Last names")
tree.heading("email", text="Emails")
tree.heading("phone", text="Phones")
tree.heading("image", text="Images")

tree.column("first_name", width=150)
tree.column("last_name", width=120)
tree.column("email", width=200)
tree.column("phone", width=120)
tree.column("image", width=150)

# ------------------ Alglaadimine ------------------
load_data_from_db(tree)

root.mainloop()
