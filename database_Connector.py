# This python file is the run tasks
# task 1
"""
Generate the table names in the given data base which have any content in them
"""
# task 2
"""
Generate text files containing 
    - table name
    - table description
    - table content (1st 10 rows)
"""

# import mysql.connector
# from mysql.connector import Error

# def list_tables(database_name):
#     try:
#         # Establish the connection
#         connection = mysql.connector.connect(
#             host='localhost',  # Replace with your host
#             user='root',  # Replace with your username
#             password='',  # Replace with your password
#             database=database_name  # The database you want to access
#         )
        
#         if connection.is_connected():
#             print(f"Connected to the database '{database_name}'")
#             cursor = connection.cursor()
#             # Execute the query to list tables
#             cursor.execute("SHOW TABLES")
#             tables = cursor.fetchall()
#             print(f"Tables in the database '{database_name}':")
#             for table in tables:
#                 print(table[0],file=file)
                
#     except Error as e:
#         print(f"Error: {e}")
        
#     finally:
#         if (connection.is_connected()):
#             cursor.close()
#             connection.close()
#             print("MySQL connection is closed")

# # Replace 'your_database_name' with the actual database name you want to check

# file = open("output.txt","w")

# list_tables('stateportal')



import mysql.connector
from mysql.connector import Error

def execute_query(query, params=None):
    try:
        # Establish the connection
        connection = mysql.connector.connect(
            host='localhost',  # Replace with your host
            user='root',  # Replace with your username
            password='',  # Replace with your password
            database='stateportal'  # The database you want to access
        )
        
        if connection.is_connected():
            # print("Connected to the database")
            cursor = connection.cursor()
            # Execute the query
            if params:
                cursor.execute(query, params)
            else:
                cursor.execute(query)
            # Fetch and print results if it's a SELECT query
            # if query.strip().upper().startswith("SELECT"):
            results = cursor.fetchall()
            return results
                # for row in results:
                #     print(row)
            # Commit the transaction if it's an INSERT, UPDATE, or DELETE query
            # else:
            #     connection.commit()
            #     print("Query executed successfully")
                
    except Error as e:
        print(f"Error: {e}")
        
    finally:
        if (connection.is_connected()):
            cursor.close()
            connection.close()
            # print("MySQL connection is closed")

# Example usage
# Replace 'your_query_here' with your actual SQL query
# custom_query = "SELECT COUNT(*) FROM dbt_audit_log"
# execute_query(custom_query)

# input_file = open('input.txt','r')
# output_file = open('output.txt','w')




tables = [
('dbt_assign_manager', 16),
('dbt_audit_log', 11877),
('dbt_beneficaryscheme', 4011),
('dbt_block', 7),
('dbt_block_scheme_mapping', 6),
('dbt_category', 4),
('dbt_content_management', 69),
('dbt_district', 700),
('dbt_district_scheme_mapping', 1335),
('dbt_feedback', 24),
('dbt_home_page_master_data_current_year', 1),
('dbt_language', 2),
('dbt_ministry', 100),
('dbt_panchayat', 262273),
('dbt_panchayat_scheme_mapping', 5),
('dbt_photogallery', 2),
('dbt_report_month_wise_beneficary_category', 1),
('dbt_report_month_wise_beneficiery_seeded', 1),
('dbt_report_month_wise_fund_transfer', 1),
('dbt_roles', 4),
('dbt_scheme', 203),
('dbt_scheme_category', 16),
('dbt_scheme_manual_data', 3925),
('dbt_state', 36),
('dbt_state_scheme_mapping', 72),
('dbt_subdistrict', 5977),
('dbt_users', 24),
('dbt_village', 645875),
('dbt_village_scheme_mapping', 6),
]

# file = open(tables[0][0]+'.txt','w')
for table in tables:
    table_name = table[0]

    file = open(table_name+'.txt','w')

    print("table name = ",table_name,file=file,end="\n\n")

    query = "Describe "+table_name;
    print("Describing table :",file=file)
    result = execute_query(query)
    print(*result,sep="\n",file=file,end="\n\n")


    query = "SELECT * FROM "+table_name+" LIMIT 10";
    result = execute_query(query)
    print(*result,sep="\n",file=file)







# table_with_rows = []
# table_without_rows = []


# for line in input_file:
#     table_name = line.split()[0]
#     query = "SELECT COUNT(*) FROM " + table_name
#     rows = execute_query(query)
#     if(rows==0):
#         table_without_rows.append(table_name)
#     else:
#         table_with_rows.append((table_name,rows))


# print("Table with rows :\n",file=output_file)
# print(*table_with_rows,sep="\n",file=output_file)
# print("\nTable with out any rows :\n",file=output_file)
# print(*table_without_rows,sep="\n",file=output_file)

# Example for an INSERT query
# insert_query = "INSERT INTO your_table_name (column1, column2) VALUES (%s, %s)"
# params = ('value1', 'value2')
# execute_query(insert_query, params)
