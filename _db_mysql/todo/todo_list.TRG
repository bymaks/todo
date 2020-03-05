TYPE=TRIGGERS
triggers='CREATE DEFINER=``@`` TRIGGER `before_delete` BEFORE DELETE ON `todo_list` FOR EACH ROW DELETE FROM todo_item WHERE todo_item.todo_list_id = OLD.id;'
sql_modes=524288
definers='@'
client_cs_names='utf8'
connection_cl_names='utf8_general_ci'
db_cl_names='utf8_general_ci'
created=158342350754
