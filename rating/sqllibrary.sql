CREATE TABLE `review_table` (
  `review_id` int(11) NOT NULL,
  `user_name` varchar(200) NOT NULL,
  `user_rating` int(1) NOT NULL,
  `user_review` text NOT NULL,
  `datetime` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE reviews(
    id bigint primary key,
    product_id bigint not null,
    user_id bigint not null,
    user_name varchar(255) not null,
    review_point int(1) not null,
    review_message text not null,
    attachment varchar(255),
    submit_date datetime DEFAULT current_timestamp not null,
    remarks varchar(255),
    foreign key (product_id) references products(id),
    foreign key (user_id) references users(id)
)ENGINE=InnoDB DEFAULT CHARSET=latin1;
